import { style } from "@angular/animations";
import { Component, OnInit, Input } from "@angular/core";
import { Router } from "@angular/router";
import { ViewCell } from "ng2-smart-table";

@Component({
    selector: 'ngx-custom-action',
    template: `
        <div class="row ">
            <div class="col-lg-3 col-md-6 d-flex justify-content-center">
                <button nbButton status="primary" (click)="onGetDetail()">
                    <nb-icon icon="folder-outline"></nb-icon>
                </button>
            </div>
            <div class="col-lg-3 col-md-6  d-flex justify-content-center">
                <button nbButton status="warning" (click)="onEdit()">
                    <nb-icon icon="edit-2-outline"></nb-icon>
                </button>
            </div>
            <div class="col-lg-3 col-md-6  d-flex justify-content-center">
                <button nbButton status="danger" (click)="onDelete($event)">
                    <nb-icon icon="trash-outline"></nb-icon>
                </button>
            </div>
            <div class="col-lg-3 col-md-6  d-flex justify-content-center">
            <button nbButton status="info" (click)="onHide()">
                    <nb-icon *ngIf="isHide()" icon="eye-off-outline"></nb-icon>
                    <nb-icon *ngIf="!isHide()" icon="eye-outline"></nb-icon>
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

export class CustomProductActionComponent implements ViewCell {
    renderValue: string;

    @Input() value: string | number;
    @Input() rowData: any;

    constructor(
        private router: Router
    ) { }

    isHide(): boolean {
        return this.rowData.isHide;
    }

    onGetDetail() {
        this.router.navigate(['/admin/products', 'detail', this.rowData.productId])
    }

    onEdit() {
        this.router.navigate(['/admin/products', 'edit', this.rowData.productId])
    }

    onDelete(event: any) {
        if (window.confirm('Are you sure you want to delete?')) {
            event.confirm.resolve();
        } else {
            event.confirm.reject();
        }
    }

    onHide() {

    }
}