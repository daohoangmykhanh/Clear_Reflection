import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { RouterModule } from '@angular/router';
import { OwlModule } from 'angular-owl-carousel';
import { GoogleMapsModule } from '@angular/google-maps';

import { HttpClientModule, HttpClientJsonpModule } from '@angular/common/http';

import { PagesRoutingModule } from './pages-routing.module';
import { ThemeModule } from '../../@theme/theme.module';

import { AboutOneComponent } from './about-one/about-one.component';
import { AboutTwoPageComponent } from './about-two/about-two.component';
import { LoginPageComponent } from './login/login.component';
import { FaqsPageComponent } from './faqs/faqs.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { ContactOnePageComponent } from './contact-one/contact-one.component';
import { ContactTwoPageComponent } from './contact-two/contact-two.component';

@NgModule( {
	declarations: [
		AboutOneComponent,
		AboutTwoPageComponent,
		FaqsPageComponent,
		LoginPageComponent,
		PageNotFoundComponent,
		ContactOnePageComponent,
		ContactTwoPageComponent,
	],

	imports: [
		CommonModule,
		PagesRoutingModule,
		ThemeModule,
		NgbModule,
		RouterModule,
		OwlModule,
		GoogleMapsModule,
		HttpClientModule,
		HttpClientJsonpModule
	]
} )

export class PagesModule { }