import { Component, OnInit, Input } from '@angular/core';

@Component({
	selector: 'molla-shop-list',
	templateUrl: './shop-list.component.html',
	styleUrls: ['./shop-list.component.scss']
})

export class ShopListComponent implements OnInit {

	@Input() type: string;
	@Input() products = [];
	@Input() loaded = false;

	grid = {
		"2cols": "col-6",
		"3cols": "col-6 col-md-4 col-lg-4",
		"4cols": "col-6 col-md-4 col-lg-4 col-xl-3"
	};
	fakeArray = {
		"list": [1, 2, 3, 4, 5],
		"2cols": [1, 2, 3, 4, 5, 6],
		"3cols": [1, 2, 3, 4, 5, 6, 7, 8, 9],
		"4cols": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
	}

	constructor() {
	}

	ngOnInit(): void {
	}
}
