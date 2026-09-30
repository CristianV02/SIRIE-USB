import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
// Importa aquí los componentes de tus dashboards (ajusta las rutas de las carpetas si es necesario):
import { EstudianteDashboardComponent } from './pages/estudiante/dashboard/dashboard.component';
import { DocenteDashboardComponent } from './pages/docente/dashboard/dashboard.component';
import { AdminDashboardComponent } from './pages/admin/dashboard/dashboard.component';

export const routes: Routes = [
  { path: '', component: LoginComponent },
  { path: 'login', component: LoginComponent },

// 2. Reemplaza LoginComponent por tu componente real de estudiante:
  { path: 'estudiante/dashboard', component: EstudianteDashboardComponent },
  { path: 'docente/dashboard', component: DocenteDashboardComponent },
  { path: 'admin/dashboard', component: AdminDashboardComponent },
  { path: 'dashboard', component: LoginComponent },

  { path: '**', redirectTo: '' }
];
