import { NgModule } from '@angular/core';
import { NbAccordionModule, NbActionsModule, NbButtonModule, NbCardModule, NbCheckboxModule, NbDatepickerModule, NbInputModule, NbListModule, NbRadioModule, NbSelectModule, NbUserModule } from '@nebular/theme';
import { NbTabsetModule } from '@nebular/theme';
import { ThemeModule } from '../../@theme/theme.module';
import { ProductsRoutingModule, routedComponents } from './products-routing.module';
import { Ng2SmartTableModule } from 'ng2-smart-table';
import { CKEditorModule } from '@ckeditor/ckeditor5-angular';
import { FormsModule } from '@angular/forms';

@NgModule({
  imports: [
    // for forms
    NbInputModule,
    NbCardModule,
    NbButtonModule,
    NbActionsModule,
    NbCheckboxModule,
    NbRadioModule,
    NbDatepickerModule,
    NbSelectModule,
    NbAccordionModule,
    // forlayout
    NbCardModule,
    NbTabsetModule,
    ThemeModule,
    Ng2SmartTableModule,
    NbListModule,
    ProductsRoutingModule,
    CKEditorModule,
    FormsModule
  ],
  declarations: [
    ...routedComponents,
  ],
})
export class ProductsModule { }
