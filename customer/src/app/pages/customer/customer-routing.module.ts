import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CartComponent } from './cart/cart.component';
import { WishlistComponent } from './wishlist/wishlist.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { CheckoutComponent } from './checkout/checkout.component';


const routes: Routes = [
    {
        path: '',
        redirectTo: 'about',
        pathMatch: 'full'
    },
    {
      path: 'cart',
      component: CartComponent
    },
    {
      path: 'wishlist',
      component: WishlistComponent
    },
    {
      path: 'dashboard',
      component: DashboardComponent
    },
    {
      path: 'checkout',
      component: CheckoutComponent
    }

];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})

export class CustomerRoutingModule { };
