/**
 * Producción: el build se publica dentro de Laravel (USB/public/sirie) y
 * Laravel lo sirve en GET /login, así que el backend está en el mismo origen.
 */
export const environment = {
  production: false,
  backendUrl: 'http://localhost:8000'
};
