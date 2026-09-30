import { Injectable, signal } from '@angular/core';

export type Tema = 'light' | 'dark';

@Injectable({ providedIn: 'root' })
export class ThemeService {
  private readonly key = 'sirie-theme';
  readonly tema = signal<Tema>('light');

  init(): void {
    let guardado: string | null = null;
    try {
      guardado = localStorage.getItem(this.key);
    } catch {
      // Almacenamiento bloqueado: se usa la preferencia del sistema.
    }
    const prefiere = matchMedia('(prefers-color-scheme: dark)').matches;
    const tema = guardado === 'light' || guardado === 'dark' ? guardado : prefiere ? 'dark' : 'light';
    this.set(tema, false);
  }

  set(tema: Tema, guardar = true): void {
    document.documentElement.setAttribute('data-theme', tema);
    this.tema.set(tema);
    if (guardar) {
      try {
        localStorage.setItem(this.key, tema);
      } catch {
        // Sin almacenamiento el tema dura solo esta visita.
      }
    }
  }
}
