import { ChangeDetectionStrategy, Component, inject } from '@angular/core';
import { ThemeService } from '../../core/theme.service';

/**
 * Cabecera institucional: banda con la marca, interruptor de tema y la
 * franja multicolor del Sistema de Información. La comparten todas las vistas.
 */
@Component({
  selector: 'app-header',
  standalone: true,
  changeDetection: ChangeDetectionStrategy.OnPush,
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent {
  protected readonly theme = inject(ThemeService);
}
