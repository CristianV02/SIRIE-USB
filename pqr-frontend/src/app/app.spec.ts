import { provideHttpClient } from '@angular/common/http';
import { TestBed } from '@angular/core/testing';
import { provideRouter } from '@angular/router';

import { LoginComponent } from './pages/login/login.component';

describe('LoginComponent', () => {
  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [LoginComponent],
      providers: [provideHttpClient(), provideRouter([])],
    }).compileComponents();
  });

  it('muestra el título y el botón Entrar', async () => {
    const fixture = TestBed.createComponent(LoginComponent);
    await fixture.whenStable();
    const el = fixture.nativeElement as HTMLElement;
    expect(el.querySelector('h1')?.textContent).toContain('Ingresar al sistema');
    expect(el.querySelector('button[type=submit]')?.textContent).toContain('Entrar');
  });

  it('valida el correo antes de enviar', async () => {
    const fixture = TestBed.createComponent(LoginComponent);
    await fixture.whenStable();
    const el = fixture.nativeElement as HTMLElement;
    const email = el.querySelector<HTMLInputElement>('#email')!;
    email.value = 'nombre-sin-arroba';
    email.dispatchEvent(new Event('input'));
    el.querySelector<HTMLButtonElement>('button[type=submit]')!.click();
    fixture.detectChanges();
    await fixture.whenStable();
    expect(el.querySelector('#email-error')?.textContent).toContain('@unisimon.edu.co');
  });
});
