import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { OwlModule } from 'angular-owl-carousel';

import { ThemeModule } from '../../@theme/theme.module';

import { TopCollectionComponent } from './top-collection/top-collection.component';
import { IndexComponent } from './index/index.component';
import { RecentCollectionComponent } from './recent-collection/recent-collection.component';
import { TranslateModule } from '@ngx-translate/core';

@NgModule({
	declarations: [
		TopCollectionComponent,
		IndexComponent,
		RecentCollectionComponent
	],

	imports: [
		CommonModule,
		RouterModule,
		NgbModule,
		OwlModule,
		ThemeModule,
    TranslateModule
	]
})

export class HomeModule { }
