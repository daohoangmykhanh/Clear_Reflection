import { style } from "@angular/animations";
import { Component, OnInit, Input } from "@angular/core";
import { Router } from "@angular/router";
import { ViewCell } from "ng2-smart-table";

@Component({
    selector: 'ngx-custom-action',
    template: `
        <div class="row ">
            <div class="col d-flex justify-content-center">
                <button nbButton status="primary" (click)="onGetDetail()">
                    <nb-icon icon="folder-outline"></nb-icon>
                </button>
            </div>
        </div>
    `,
    styles: [
        `
            button {
                padding: 0.5rem 0.7rem;
            }
            i {
                font-size: 1.2rem;
            }
        `
    ]
})

export class CustomCustomerActionComponent implements ViewCell {
    renderValue: string;

    @Input() value: string | number;
    @Input() rowData: any;

    constructor(
        private router: Router
    ) { }

    onGetDetail() {
        this.router.navigate(['/admin/customers', 'detail', this.rowData.accountId])
    }
}