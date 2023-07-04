import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router, NavigationStart, NavigationEnd } from '@angular/router';
import { Subscription } from 'rxjs';

@Component({
	selector: 'molla-main-menu',
	templateUrl: './main-menu.component.html',
	styleUrls: ['./main-menu.component.scss']
})
export class MainMenuComponent implements OnInit, OnDestroy {

	current = '/'; // current Url

	private subscr: Subscription;

	constructor(private router: Router) {
		this.subscr = this.router.events.subscribe(event => {
			if (event instanceof NavigationStart) {
				this.current = event.url;
			} else if (event instanceof NavigationEnd) {
				this.current = event.url;
			}
		});
	}

	ngOnInit(): void {
	}

	ngOnDestroy(): void {
		this.subscr.unsubscribe();
	}

}
