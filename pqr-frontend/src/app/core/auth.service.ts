import { HttpClient } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';
import { Observable, switchMap } from 'rxjs';

import { environment } from '../../environments/environment';

export interface Credenciales {
  email: string;
  password: string;
  remember?: boolean;
}

export interface RespuestaLogin {
  redirect: string;
}

@Injectable({ providedIn: 'root' })
export class AuthService {
  private readonly http = inject(HttpClient);

  /**
   * Inicia sesión contra Laravel usando la URL completa del backend
   * y habilitando el envío de credenciales (cookies de Sanctum).
   */
  login(credenciales: Credenciales): Observable<RespuestaLogin> {
    // Apuntamos explícitamente al backend de Laravel configurado en el environment
    const csrfUrl = `${environment.backendUrl}/sanctum/csrf-cookie`;
    const loginUrl = `${environment.backendUrl}/api/login`;

    // <-- Agrega esta línea para ver qué dirección exacta está usando
    console.log('URL de conexión al backend:', loginUrl);

    return this.http
      .get<void>(csrfUrl, { withCredentials: true })
      .pipe(
        switchMap(() =>
          this.http.post<RespuestaLogin>(loginUrl, credenciales, { withCredentials: true })
        )
      );
  }

  /** URL de una página que todavía sirve Laravel (Blade). */
  backend(ruta: string): string {
    return `${environment.backendUrl}${ruta}`;
  }
}
