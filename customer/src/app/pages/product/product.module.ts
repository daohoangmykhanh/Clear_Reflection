import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { NgbModule, NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { LightboxModule } from 'ngx-lightbox';
import { OwlModule } from 'angular-owl-carousel';

import { ProductRoutingModule } from './product-routing.module';
import { ThemeModule } from '../../@theme/theme.module';

import { ProductDetailComponent } from './product-detail/product-detail.component';
import { RelatedProductsOneComponent } from './shared/related-products/related-products-one/related-products-one.component';
import { ToggleSidebarComponent } from './shared/toggle-sidebar/toggle-sidebar.component';
import { RelatedProductsTwoComponent } from './shared/related-products/related-products-two/related-products-two.component';
import { GalleryComponent } from './shared/gallery/gallery.component';
import { DetailComponent } from './shared/details/detail.component';
import { InfoTabsComponent } from './shared/info-tabs/info-tabs.component';
import { ProductCategoryComponent } from './product-category/product-category.component';
import { ProductShopComponent } from './product-shop/product-shop.component';
import { NouisliderModule } from 'ng2-nouislider';
import { ShopSidebarComponent } from './shared/shop-sidebar/shop-sidebar.component';
import { ShopListComponent } from './shared/shop-list/shop-list.component';

@NgModule({
	declarations: [
    ProductShopComponent,
    ProductCategoryComponent,
		ProductDetailComponent,

    ShopListComponent,
    ShopSidebarComponent,
		GalleryComponent,
		DetailComponent,
		InfoTabsComponent,
		RelatedProductsOneComponent,
    RelatedProductsTwoComponent,
		ToggleSidebarComponent,
	],

	imports: [
		CommonModule,
		ProductRoutingModule,
		ThemeModule,
		RouterModule,
		NgbModule,
		OwlModule,
		LightboxModule,
    OwlModule,
    NouisliderModule
	],

	exports: [],

	providers: [
		NgbModal
	]
})

export class ProductModule { }
