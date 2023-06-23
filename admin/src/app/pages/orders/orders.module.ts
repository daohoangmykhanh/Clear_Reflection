import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { OrdersComponent } from './orders.component';
import { OrderDetailComponent } from './order-detail/order-detail.component';
import { RouterModule } from '@angular/router';
import { OrderListComponent } from './order-list/order-list.component';
import { OrdersRoutingModule } from './orders-routing.module';
import { NbAccordionModule, NbActionsModule, NbAutocompleteComponent, NbAutocompleteModule, NbButtonModule, NbCardModule, NbCheckboxModule, NbDatepickerModule, NbInputModule, NbRadioModule, NbSelectModule } from '@nebular/theme';
import { Ng2SmartTableModule } from 'ng2-smart-table';
import { OrderAddComponent } from './order-add/order-add.component';
import { OrderEditComponent } from './order-edit/order-edit.component';
import { Ng2CompleterModule } from 'ng2-completer';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';



@NgModule({
  declarations: [
    OrdersComponent,
    OrderDetailComponent,
    OrderListComponent,
    OrderAddComponent,
    OrderEditComponent,
  ],
  imports: [
    RouterModule,
    CommonModule,
    OrdersRoutingModule,
    NbCardModule,
    Ng2SmartTableModule,
    Ng2CompleterModule,
    NbInputModule,
    NbButtonModule,
    NbActionsModule,
    NbCheckboxModule,
    NbRadioModule,
    NbDatepickerModule,
    NbSelectModule,
    NbAccordionModule,
    FormsModule,
    NbAutocompleteModule,
    ReactiveFormsModule
  ]
})
export class OrdersModule { }