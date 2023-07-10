import { Component, OnInit, OnDestroy } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { Product } from 'src/app/@core/models/product';
import { ApiService } from 'src/app/@core/services/api.service';
import { ProductService } from 'src/app/@core/services/product/product.service';

@Component({
	selector: 'product-detail',
	templateUrl: './product-detail.component.html',
	styleUrls: ['./product-detail.component.scss']
})

export class ProductDetailComponent implements OnInit, OnDestroy {

	product: Product;
	prev: Product;
	next: Product;
	related = [];
	loaded = false;

	constructor(
		public apiService: ApiService,
		private activeRoute: ActivatedRoute,
		public router: Router,
    private productDetail: ProductService
	) {
		activeRoute.params.subscribe(params => {
			this.apiService.getSingleProduct(params['slug']).subscribe(result => {
				if (result === null) {
					this.router.navigate(['/pages/404']);
				}

				this.product = result.product;
				this.related = result.relatedProducts;
				this.loaded = true;
			});
		});
	}

	ngOnInit(): void {
	}

	ngOnDestroy(): void {
		document.querySelector('body').classList.remove('sidebar-filter-active');
	}
}
