import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProductDetailComponent } from './product-detail/product-detail.component';
import { ProductShopComponent } from './product-shop/product-shop.component';
import { ProductCategoryComponent } from './product-category/product-category.component';

const routes: Routes = [
  {
    path: 'category',
    component: ProductCategoryComponent
  },
  {
      path: 'detail/:slug',
      component: ProductDetailComponent
  },
  {
		path: 'shop/:type',
		component: ProductShopComponent
	},
  {
    path: 'shop',
    component: ProductShopComponent
  },{
		path: '',
		pathMatch: 'full',
		redirectTo: 'shop/list'
	},
]

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})

export class ProductRoutingModule { };
