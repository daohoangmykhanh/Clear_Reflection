import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { RouterModule } from '@angular/router';
import { OwlModule } from 'angular-owl-carousel';
import { GoogleMapsModule } from '@angular/google-maps';

import { HttpClientModule, HttpClientJsonpModule } from '@angular/common/http';

import { ThemeModule } from '../../@theme/theme.module';

import { AboutPageComponent } from './about/about.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { ContactPageComponent } from './contact/contact.component';
import { OthersRoutingModule } from './others-routing.module';

@NgModule( {
	declarations: [
		AboutPageComponent,
		PageNotFoundComponent,
		ContactPageComponent,
	],

	imports: [
    OthersRoutingModule,
		CommonModule,
		ThemeModule,
		NgbModule,
		RouterModule,
		OwlModule,
		GoogleMapsModule,
		HttpClientModule,
		HttpClientJsonpModule
	]
} )

export class OthersModule { }
