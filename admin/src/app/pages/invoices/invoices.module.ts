import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { InvoicesComponent } from './invoices.component';
import { InvoiceListComponent } from './invoice-list/invoice-list.component';
import { InvoiceDetailComponent } from './invoice-detail/invoice-detail.component';
import { InvoiceRoutingModule } from './invoices-routing.module';
import { RouterModule } from '@angular/router';
import { NbAccordionModule, NbActionsModule, NbButtonModule, NbCardModule, NbCheckboxModule, NbDatepickerModule, NbInputModule, NbRadioModule, NbSelectModule } from '@nebular/theme';
import { Ng2SmartTableModule } from 'ng2-smart-table';



@NgModule({
  declarations: [
    InvoicesComponent,
    InvoiceListComponent,
    InvoiceDetailComponent
  ],
  imports: [
    CommonModule,
    InvoiceRoutingModule,
    RouterModule,
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
export class InvoicesModule { }
