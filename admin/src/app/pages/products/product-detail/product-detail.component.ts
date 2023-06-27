import { Component, QueryList, ViewChildren } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Product } from '../../../@core/models/product/product.model';
import { ProductService } from '../../../@core/services/product/product.service';
import { NbAccordionItemComponent } from '@nebular/theme';

@Component({
  selector: 'ngx-product-detail',
  templateUrl: './product-detail.component.html',
  styleUrls: ['./product-detail.component.scss']
})
export class ProductDetailComponent {
  @ViewChildren(NbAccordionItemComponent) accordions: QueryList<NbAccordionItemComponent>;

  productId: string;
  product: Product;

  constructor(
    private activatedRoute: ActivatedRoute,
    private productService: ProductService,
    private router: Router
  ) {
    this.activatedRoute.params.subscribe(
      params => {
        this.productId = params['id']
        this.productService.findById(params['id']).subscribe(data => this.product = data)
      }
    )
  }

  onEdit() {
    this.router.navigate(['/admin/products', 'edit', this.productId])
  }


}
