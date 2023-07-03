import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { RouterModule } from '@angular/router';
import { OwlModule } from 'angular-owl-carousel';

import { HttpClientModule, HttpClientJsonpModule } from '@angular/common/http';

import { ThemeModule } from '../../@theme/theme.module';

import { CustomerRoutingModule } from './customer-routing.module';
import { CartComponent } from './cart/cart.component';
import { WishlistComponent } from './wishlist/wishlist.component';
import { CheckoutComponent } from './checkout/checkout.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ProductModule } from '../product/product.module';

@NgModule( {
	declarations: [
    CartComponent,
    WishlistComponent,
    CheckoutComponent,
    DashboardComponent
	],

	imports: [
		CommonModule,
		ThemeModule,
		NgbModule,
		RouterModule,
		OwlModule,
		HttpClientModule,
		HttpClientJsonpModule,
    CustomerRoutingModule,
	]
} )

export class CustomerModule { }
