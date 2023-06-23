import { ModuleWithProviders, NgModule, Optional, Provider, SkipSelf } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NbAuthModule, NbDummyAuthStrategy } from '@nebular/auth';
import { NbSecurityModule, NbRoleProvider } from '@nebular/security';
import { of as observableOf } from 'rxjs';

import { throwIfAlreadyLoaded } from './module-import-guard';
import {
  AnalyticsService,
  LayoutService,
  PlayerService,
  SeoService,
  StateService,
} from './utils';

import { UserService } from './services/users.service';
import { SmartTableService } from './services/smart-table.service';
import { UserActivityService } from './services/user-activity/user-activity.service';
import { OrdersChartService } from './services/orders-profit-chart/orders-chart.service';
import { ProfitChartService } from './services/orders-profit-chart/profit-chart.service';
import { TrafficListService } from './services/traffic/traffic-list.service';
import { OrdersProfitChartService } from './services/orders-profit-chart/orders-profit-chart.service';
import { TrafficBarService } from './services/traffic/traffic-bar.service';
import { ProgressInfoService } from './services/progress-bar-chart/progress-info.service';
import { ServiceDataModule } from './services/service-data.module';



const SERVICES: Provider[] = [
  UserService,
  SmartTableService,
  UserActivityService,
  OrdersChartService,
  ProfitChartService,
  TrafficListService,
  OrdersProfitChartService,
  TrafficBarService,
  ProgressInfoService,
];

export class NbSimpleRoleProvider extends NbRoleProvider {
  getRole() {
    // here you could provide any role based on any auth flow
    return observableOf('guest');
  }
}

export const NB_CORE_PROVIDERS = [
  ...SERVICES,
  ...ServiceDataModule.forRoot().providers,
  ...NbAuthModule.forRoot({

    strategies: [
      NbDummyAuthStrategy.setup({
        name: 'email',
        delay: 3000,
      }),
    ],
    forms: {
      login: {
      },
      register: {
      },
    },
  }).providers,

  NbSecurityModule.forRoot({
    accessControl: {
      guest: {
        view: '*',
      },
      user: {
        parent: 'guest',
        create: '*',
        edit: '*',
        remove: '*',
      },
    },
  }).providers,

  {
    provide: NbRoleProvider, useClass: NbSimpleRoleProvider,
  },
  AnalyticsService,
  LayoutService,
  PlayerService,
  SeoService,
  StateService,
];

@NgModule({
  imports: [
    CommonModule,
  ],
  exports: [
    NbAuthModule,
  ],
  declarations: [],
})
export class CoreModule {
  constructor(@Optional() @SkipSelf() parentModule: CoreModule) {
    throwIfAlreadyLoaded(parentModule, 'CoreModule');
  }

  static forRoot(): ModuleWithProviders<CoreModule> {
    return {
      ngModule: CoreModule,
      providers: [

        ...NB_CORE_PROVIDERS,
      ],
    };
  }
}
