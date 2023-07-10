import { Component, OnInit } from '@angular/core';

import { Product } from 'src/app/@core/models/product';
import { CompareService } from 'src/app/@core/services/compare.service';

@Component({
	selector: 'molla-compare-menu',
	templateUrl: './compare-menu.component.html',
	styleUrls: ['./compare-menu.component.scss']
})

export class CompareMenuComponent implements OnInit {

	constructor(public compareService: CompareService) { }

	ngOnInit(): void {
	}

	removeFromCompare($event: Event, product: Product) {
		$event.preventDefault();
		this.compareService.removeFromCompare(product);
	}

	clearAllCompare($event: Event) {
		$event.preventDefault();
		this.compareService.clearAllCompare();
	}
}
