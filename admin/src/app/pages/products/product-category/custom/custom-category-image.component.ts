import { style } from "@angular/animations";
import { Component, OnInit, Input } from "@angular/core";
import { Router } from "@angular/router";
import { ViewCell } from "ng2-smart-table";
import { ProductCategoryService } from "../../../../@core/services/product/product-category.service";

@Component({
    template: `
        <img [src]="renderValue" class='d-block mx-auto' alt="Category Image" style="height: 75px; width: auto"/>
    `,
})

export class CustomCategoryImageComponent implements ViewCell, OnInit {
    renderValue: string;

    @Input() value: string | number;
    @Input() rowData: any;

    constructor(private categoryService: ProductCategoryService) {
    }

    ngOnInit(): void {
        this.renderValue = this.value.toString()
        
    }
}