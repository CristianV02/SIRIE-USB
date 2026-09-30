import { HttpErrorResponse } from '@angular/common/http';
import { ChangeDetectionStrategy, Component, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router'; // <-- 1. Importar el Router aquí

import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';

import { AuthService } from '../../core/auth.service';
import { HeaderComponent } from '../../shared/header/header.component';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, HeaderComponent],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {
  private readonly auth = inject(AuthService);
  private readonly router = inject(Router); // <-- 2. Inyectar el Router en la clase

  protected readonly form = inject(FormBuilder).nonNullable.group({
    email: ['', [Validators.required, Validators.email]],
    password: ['', Validators.required],
  });

  protected readonly enviando = signal(false);
  protected readonly error = signal<string | null>(null);
  protected readonly intentado = signal(false);

  protected readonly recuperarUrl = this.auth.backend('/forgot-password');

  protected errorDe(campo: 'email' | 'password'): string | null {
    const control = this.form.controls[campo];
    if (!control.invalid || !(control.touched || this.intentado())) {
      return null;
    }
    if (campo === 'email') {
      return control.hasError('required')
        ? 'Escribe tu correo institucional.'
        : 'Revisa que el formato del correo sea válido.';
    }
    return 'Escribe tu contraseña.';
  }

  protected entrar(): void {
    this.intentado.set(true);
    this.error.set(null);
    if (this.form.invalid || this.enviando()) {
      this.form.markAllAsTouched();
      return;
    }

    this.enviando.set(true);
    this.auth.login(this.form.getRawValue()).subscribe({
      next: (response: any) => {
        this.enviando.set(false);
        // 3. Usar el router de Angular para redirigir de forma interna sin recargar la página
        const destino = response.redirect || '/dashboard';
        this.router.navigateByUrl(destino);
      },
      error: (e: HttpErrorResponse) => {
        this.enviando.set(false);
        this.error.set(this.mensaje(e));
      },
    });
  }

  private mensaje(e: HttpErrorResponse): string {
    const errores = e.error?.errors as Record<string, string[]> | undefined;
    if (e.status === 422 && errores) {
      return errores['email']?.[0] ?? errores['password']?.[0] ?? 'Revisa los datos e intenta de nuevo.';
    }
    if (e.status === 419) {
      return 'La sesión del formulario expiró. Vuelve a presionar Entrar.';
    }
    if (e.status === 0) {
      return 'No hay conexión con el servidor. Revisa tu red y vuelve a intentarlo.';
    }
    return 'No pudimos iniciar sesión en este momento. Intenta de nuevo en unos minutos.';
  }
}
