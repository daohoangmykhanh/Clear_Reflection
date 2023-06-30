import { Component, OnInit } from '@angular/core';

import { ModalService } from 'src/app/@core/services/modal.service';
import { ApiService } from 'src/app/@core/services/api.service';
import { UtilsService } from 'src/app/@core/services/utils.service';

import { introSlider, brandSlider } from '../data';

@Component({
	selector: 'molla-index',
	templateUrl: './index.component.html',
	styleUrls: ['./index.component.scss']
})

export class IndexComponent implements OnInit {

	products = [];
	loaded = false;
	introSlider = introSlider;
	brandSlider = brandSlider;

	constructor(public apiService: ApiService, public utilsService: UtilsService, private modalService: ModalService,) {
		this.modalService.openNewsletter();

		this.apiService.fetchHomeData().subscribe(result => {
			this.products = result.products;
			this.loaded = true;
		})
	}

	ngOnInit(): void {
	}
}
