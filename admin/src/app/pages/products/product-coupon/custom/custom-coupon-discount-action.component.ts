import { style } from "@angular/animations";
import { Component, OnInit, Input } from "@angular/core";
import { Router } from "@angular/router";
import { ViewCell } from "ng2-smart-table";
import { ProductCategoryService } from "../../../../@core/services/product/product-category.service";

@Component({
    selector: 'ngx-custom-action',
    template: `
        {{renderValue}}
    `,
})

export class CustomCouponDiscountActionComponent implements ViewCell, OnInit{
    renderValue: string;

    @Input() value: string | number;
    @Input() rowData: any;

    constructor() {
    }
    
    ngOnInit(): void {
        if(this.rowData.couponType.couponTypeName == 'percent') {
            this.renderValue = this.value + '%'
        } else {
            this.renderValue = '$' + this.value
        }
        
    }
}