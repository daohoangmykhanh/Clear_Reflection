import { Component, OnInit, Input } from '@angular/core';
import { Product } from 'src/app/@core/models/product';

@Component({
	selector: 'product-info-tabs',
	templateUrl: './info-tabs.component.html',
	styleUrls: ['./info-tabs.component.scss']
})

export class InfoTabsComponent implements OnInit {

	@Input() product: Product;

	constructor() { }

	ngOnInit(): void {
	}

	setRating = (event: any) => {
		event.preventDefault();

		if (event.currentTarget.parentNode.querySelector('.active')) {
			event.currentTarget.parentNode.querySelector('.active').classList.remove('active');
		}

		event.currentTarget.classList.add('active');
	}
}
