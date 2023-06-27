import { UtilsService } from './../../../@core/services/utils.service';
import { Component } from '@angular/core';
import { NbToastrService } from '@nebular/theme';
import { capitalizeString } from '../../../@core/services/string-utils';

@Component({
  selector: 'ngx-one-column-layout',
  styleUrls: ['./one-column.layout.scss'],
  template: `
    <nb-layout windowMode>
      <nb-layout-header fixed>
        <ngx-header></ngx-header>
      </nb-layout-header>

      <nb-sidebar class="menu-sidebar" tag="menu-sidebar" responsive>
        <ng-content select="nb-menu"></ng-content>
      </nb-sidebar>

      <nb-layout-column>
        <ng-content select="router-outlet"></ng-content>
      </nb-layout-column>

      <nb-layout-footer fixed>
        <ngx-footer></ngx-footer>
      </nb-layout-footer>
    </nb-layout>
  `,
})
export class OneColumnLayoutComponent {
  constructor(
    private toastService: NbToastrService,
    private utilsService: UtilsService
  ) {
    this.utilsService.toastState$.subscribe(state => {
      if(state != null) {
        let message: string = 
          capitalizeString(state.behavior) + ' ' +
          capitalizeString(state.model) + ' ' +
          (state.status === 'success' ? 'Successfully' : 'Failed')
        this.toastService.show(message, 'Notification', {status: state.status, duration: 3000});
      }
    })
  }
}
