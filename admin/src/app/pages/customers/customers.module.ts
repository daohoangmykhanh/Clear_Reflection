import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CustomersComponent } from './customers.component';
import { CustomerListComponent } from './customer-list/customer-list.component';
import { CustomerOrderComponent } from './customer-order/customer-order.component';
import { CustomerDetailComponent } from './customer-detail/customer-detail.component';
import { CustomersRoutingModule } from './customers-routing.module';
import { RouterModule } from '@angular/router';
import { NbAccordionModule, NbActionsModule, NbButtonModule, NbCardModule, NbCheckboxModule, NbDatepickerModule, NbInputModule, NbRadioModule, NbSelectModule } from '@nebular/theme';
import { Ng2SmartTableModule } from 'ng2-smart-table';



@NgModule({
  declarations: [
    CustomersComponent,
    CustomerListComponent,
    CustomerOrderComponent,
    CustomerDetailComponent
  ],
  imports: [
    CustomersRoutingModule,
    RouterModule,
    CommonModule,
    NbCardModule,
    Ng2SmartTableModule,
    NbInputModule,
    NbButtonModule,
    NbActionsModule,    
    NbCheckboxModule,
    NbRadioModule,
    NbDatepickerModule,
    NbSelectModule,
    NbAccordionModule,
  ]
})
export class CustomersModule { }
