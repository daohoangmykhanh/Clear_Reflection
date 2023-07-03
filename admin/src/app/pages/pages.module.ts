import { NgModule } from '@angular/core';
import { NbMenuModule } from '@nebular/theme';

import { ThemeModule } from '../@theme/theme.module';
import { PagesComponent } from './pages.component';
import { DashboardModule } from './dashboard/dashboard.module';
import { PagesRoutingModule } from './pages-routing.module';
import { ProductsModule } from './products/products.module';
import { OrdersModule } from './orders/orders.module';
import { CustomersModule } from './customers/customers.module';

@NgModule({
  imports: [
    PagesRoutingModule,
    ThemeModule, // @theme
    NbMenuModule,
    
    DashboardModule,
    ProductsModule,
    OrdersModule,
    CustomersModule
  ],
  declarations: [
    PagesComponent,
  ],
})
export class PagesModule {
}
