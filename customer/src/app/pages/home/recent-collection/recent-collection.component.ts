import { Component, OnInit, Input } from '@angular/core';

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

	constructor() {
	}

	ngOnInit(): void {
	}

}
