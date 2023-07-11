import { Component, OnInit, Input, ViewChild } from '@angular/core';

import { shopData } from '../data';
import { ActivatedRoute, Router } from '@angular/router';
import { ProductCategory } from 'src/app/@core/models/product/product-category.model';
import { ProductCategoryService } from 'src/app/@core/services/product/product-category.service';
import { ProductColor } from 'src/app/@core/models/product/product-color.model';
import { ProductColorService } from 'src/app/@core/services/product/product-color.service';

@Component({
	selector: 'molla-shop-sidebar',
	templateUrl: './shop-sidebar.component.html',
	styleUrls: ['./shop-sidebar.component.scss']
})

export class ShopSidebarComponent implements OnInit {

	@Input() toggle = false;
	shopData = shopData;
	params = {};
  categories: ProductCategory[]
  colors: ProductColor[]
	@ViewChild('priceSlider') priceSlider: any;

	constructor(
    public activeRoute: ActivatedRoute,
    public router: Router,
    private categoryService: ProductCategoryService,
    private colorService: ProductColorService
  ) {
		activeRoute.queryParams.subscribe(params => {
			this.params = params;
		})

    this.categoryService.findAll().subscribe(
      data => this.categories = data.categories
    )

    this.colorService.findAll().subscribe(
      data => {
        this.colors = data.product_colors
        console.log(this.colors);

      }
    )
	}

	ngOnInit(): void {
	}

	containsAttrInUrl(type: string, value: string) {
		const currentQueries = this.params[type] ? this.params[type].split(',') : [];
		return currentQueries && currentQueries.includes(value);
	}

  onAttrClick(attr: string, value: string) {
    let url = this.getUrlForAttrs(attr, value);
    this.router.navigate([], { queryParams: { [attr]: this.getUrlForAttrs(attr, value), page: 1 }, queryParamsHandling: 'merge' });
  }

	getUrlForAttrs(type: string, value: string) {
		let currentQueries = this.params[type] ? this.params[type].split(',') : [];
		currentQueries = this.containsAttrInUrl(type, value) ? currentQueries.filter(item => item !== value) : [...currentQueries, value];
		return currentQueries.join(',');
	}


}
