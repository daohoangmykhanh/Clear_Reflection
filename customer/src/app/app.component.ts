import { Component, HostListener } from '@angular/core';
import { Router, NavigationEnd } from '@angular/router';
import { ViewportScroller } from '@angular/common';
import { filter, first } from 'rxjs/operators';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';

import { Store } from '@ngrx/store';

import { StoreService } from './@core/services/store.service';
import { UtilsService } from './@core/services/utils.service';

import { RefreshStoreAction } from 'src/app/@core/services/actions';
import { environment } from 'src/environments/environment';
import { TranslateService } from '@ngx-translate/core';

declare var $: any;

@Component({
	selector: 'molla-root',
	templateUrl: './app.component.html'
})

export class AppComponent {

	constructor(
		public store: Store<any>,
		public router: Router,
		public viewPort: ViewportScroller,
		public storeService: StoreService,
		public utilsService: UtilsService,
		public modalService: NgbModal,
    private translateService: TranslateService
	) {
    this.translateService.setDefaultLang('en-US');

		const navigationEnd = this.router.events.pipe(
			filter(event => event instanceof NavigationEnd)
		);

		navigationEnd.pipe(first()).subscribe(() => {
			document.querySelector('body')?.classList.add('loaded');
			var timer = setInterval(() => {
				if( window.getComputedStyle( document.querySelector('body') ).visibility == 'visible') {
					clearInterval(timer);
					$('.owl-carousel').trigger('refresh.owl.carousel');
				}
			}, 300);
		});

		navigationEnd.subscribe((event: any) => {
			if (!event.url.includes('/shop/sidebar') && !event.url.includes('/shop/nosidebar') && !event.url.includes('/shop/market') && !event.url.includes('/blog')) {
				this.viewPort.scrollToPosition([0, 0]);
			}

			this.modalService.dismissAll();

			if (event.url.startsWith('/product') || (event.url.startsWith('/pages') && !event.url.includes('faq'))) {
				document.querySelector('.header').classList.remove('border-0');
			} else {
				document.querySelector('.header').classList.add('border-0');
			}
		})

		if (localStorage.getItem("molla-angular-demo") !== environment.demo) {
			this.store.dispatch(new RefreshStoreAction());
		}

		localStorage.setItem("molla-angular-demo", environment.demo);
	}

	@HostListener('window: scroll', ['$event'])
	onWindowScroll(e: Event) {
		this.utilsService.setStickyHeader();
	}

	hideMobileMenu() {
		document.querySelector('body').classList.remove('mmenu-active');
		document.querySelector('html').style.overflowX = 'unset';
	}
}
