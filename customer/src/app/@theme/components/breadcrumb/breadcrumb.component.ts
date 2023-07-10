import { Component, OnInit, Input } from '@angular/core';

import { Product } from '../../../@core/models/product';

import { environment } from 'src/environments/environment';

@Component({
	selector: 'molla-breadcrumb',
	templateUrl: './breadcrumb.component.html',
	styleUrls: ['./breadcrumb.component.scss']
})

export class BreadcrumbComponent implements OnInit {

	@Input() current: string;

	SERVER_URL = environment.SERVER_URL;

	constructor() {
	}

	ngOnInit(): void {
	}
}
