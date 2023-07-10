import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LayoutComponent } from './@theme/layout/layout.component';
import { IndexComponent } from './pages/home/index/index.component';

const routes: Routes = [
	{
		path: '',
		component: LayoutComponent,
		children: [
			{
				path: '',
				pathMatch: 'full',
				component: IndexComponent
			},
			{
				path: 'pages',
				loadChildren: () => import( './pages/others/others.module' ).then( m => m.OthersModule )
			},
			{
				path: 'customer',
				loadChildren: () => import( './pages/customer/customer.module' ).then( m => m.CustomerModule )
			},
			{
				path: 'product',
				loadChildren: () => import( './pages/product/product.module' ).then( m => m.ProductModule )
			}
		]
	},
	{
		path: '**',
		redirectTo: '/pages/404'
	}
];

@NgModule( {
	imports: [ RouterModule.forRoot( routes, { useHash: false, anchorScrolling: 'disabled', scrollPositionRestoration: 'disabled' } ) ],
	exports: [ RouterModule ]
} )

export class AppRoutingModule { }
