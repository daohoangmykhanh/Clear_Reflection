import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { OwlModule } from 'angular-owl-carousel';

import { ThemeModule } from '../../@theme/theme.module';

import { TopCollectionComponent } from './top-collection/top-collection.component';
import { IndexComponent } from './index/index.component';
import { BlogCollectionComponent } from './blog-collection/blog-collection.component';
import { RecentCollectionComponent } from './recent-collection/recent-collection.component';

@NgModule({
	declarations: [
		TopCollectionComponent,
		IndexComponent,
		BlogCollectionComponent,
		RecentCollectionComponent
	],

	imports: [
		CommonModule,
		RouterModule,
		NgbModule,
		OwlModule,
		ThemeModule
	]
})

export class HomeModule { }
