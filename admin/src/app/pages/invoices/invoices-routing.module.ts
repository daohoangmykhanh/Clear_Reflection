import { NgModule } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";
import { InvoiceListComponent } from "./invoice-list/invoice-list.component";
import { InvoicesComponent } from "./invoices.component";
import { InvoiceDetailComponent } from "./invoice-detail/invoice-detail.component";

const routes: Routes = [
    {
        path: "",
        component: InvoicesComponent,
        children: [
            {
                path: "list",
                component: InvoiceListComponent,
            },
            {
                path: "detail/:id",
                component: InvoiceDetailComponent,
            },
        ],
    },
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class InvoiceRoutingModule { }

export const routedComponents = [
    InvoicesComponent,
    InvoiceListComponent,
    InvoiceDetailComponent,
];
