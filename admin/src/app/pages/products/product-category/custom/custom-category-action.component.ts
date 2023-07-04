import { style } from "@angular/animations";
import { Component, OnInit, Input } from "@angular/core";
import { Router } from "@angular/router";
import { ViewCell } from "ng2-smart-table";
import { ProductCategoryService } from "../../../../@core/services/product/product-category.service";

@Component({
    selector: 'ngx-custom-action',
    template: `
        <div class="row no-gutters">
            <div class="col-lg-6  d-flex justify-content-center">
                <button nbButton status="warning" (click)="onEdit()">
                    <nb-icon icon="edit-2-outline"></nb-icon>
                </button>
            </div>
            <div class="col-lg-6  d-flex justify-content-center">
                <button nbButton status="danger" (click)="onDelete($event)">
                    <nb-icon icon="trash-outline"></nb-icon>
                </button>
            </div>
        </div>
    `,
})

export class CustomCategoryActionComponent implements ViewCell {
    renderValue: string;

    @Input() value: string | number;
    @Input() rowData: any;

    constructor(private categoryService: ProductCategoryService) {
    }

    onEdit() {
        this.categoryService.updateHandleAndRowData('edit', this.rowData);
    }

    onDelete(event: any) {
        if (window.confirm('Are you sure you want to delete?')) {
            event.confirm.resolve();
        } else {
            event.confirm.reject();
        }
    }

}