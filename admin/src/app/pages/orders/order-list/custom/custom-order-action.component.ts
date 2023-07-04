import { style } from "@angular/animations";
import { Component, OnInit, Input } from "@angular/core";
import { Router } from "@angular/router";
import { ViewCell } from "ng2-smart-table";

@Component({
    selector: 'ngx-custom-action',
    template: `
        <div class="row ">
            <div class="col-lg-4 d-flex justify-content-center">
                <button nbButton status="primary" (click)="onGetDetail()">
                    <nb-icon icon="folder-outline"></nb-icon>
                </button>
            </div>
            <div class="col-lg-4  d-flex justify-content-center">
                <button nbButton status="warning" (click)="onEdit()">
                    <nb-icon icon="edit-2-outline"></nb-icon>
                </button>
            </div>
            <div class="col-lg-4  d-flex justify-content-center">
                <button nbButton status="danger" (click)="onDelete($event)">
                    <nb-icon icon="trash-outline"></nb-icon>
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

export class CustomOrderActionComponent implements ViewCell {
    renderValue: string;

    @Input() value: string | number;
    @Input() rowData: any;

    constructor(
        private router: Router
    ) { }

    onGetDetail() {
        this.router.navigate(['/admin/orders', 'detail', this.rowData.orderId])
    }

    onEdit() {
        this.router.navigate(['/admin/orders', 'edit', this.rowData.orderId])
    }

    onDelete(event: any) {
        if (window.confirm('Are you sure you want to delete?')) {
            event.confirm.resolve();
        } else {
            event.confirm.reject();
        }
    }

}