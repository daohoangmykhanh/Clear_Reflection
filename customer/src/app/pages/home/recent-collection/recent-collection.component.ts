import { Component, OnInit, Input } from '@angular/core';
import { ProductService } from 'src/app/@core/services/product/product.service';

@Component({
  selector: 'molla-recent-collection',
  templateUrl: './recent-collection.component.html',
  styleUrls: ['./recent-collection.component.scss']
})

export class RecentCollectionComponent implements OnInit {

  @Input() products = [];
	@Input() loaded = false;

	categories = [['all'], ['furniture'], ['decoration'], ['lighting']];
	titles = { "all": "All", "furniture": "Furniture", "decoration": "Home Decor", "lighting": "Lighting" };
	hasMore: boolean = true;
	loadMoreLoading: boolean = false;
	loadCount: number = 8;

	constructor(
    private productService: ProductService
  ) {
    this.productService.find8Products().subscribe(data => {
      this.products = data.products
    })
	}

	ngOnInit(): void {
	}

}
