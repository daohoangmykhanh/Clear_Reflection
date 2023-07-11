import { Component, OnInit, HostListener } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Product } from 'src/app/@core/models/product/product.model';

import { ApiService } from 'src/app/@core/services/api.service';
import { ProductService } from 'src/app/@core/services/product/product.service';
import { UtilsService } from 'src/app/@core/services/utils.service';

@Component({
  selector: 'shop-product-shop-page',
  templateUrl: './product-shop.component.html',
  styleUrls: ['./product-shop.component.scss'],
})

export class ProductShopComponent implements OnInit {
  products = [];
  perPage = 12;
  type = 'list';
  totalCount = 0;
  orderBy = 'default';
  pageTitle = 'List';
  toggle = false;
  searchTerm = '';
  loaded = false;
  firstLoad = false;

  constructor(
    public activeRoute: ActivatedRoute,
    public router: Router,
    public utilsService: UtilsService,
    public apiService: ApiService,
    public productService: ProductService
  ) {
    this.activeRoute.params.subscribe(params => {
      this.type = params['type'];
      console.log(this.type)
      if (this.type == 'list') {
        this.pageTitle = 'List';
      } else if (this.type == '2cols') {
        this.pageTitle = 'Grid 2 Columns';
      } else if (this.type == '3cols') {
        this.pageTitle = 'Grid 3 Columns';
      } else if (this.type == '4cols') {
        this.pageTitle = 'Grid 4 Columns';
      }
    });

    this.activeRoute.queryParams.subscribe(params => {
      this.loaded = false;

      if (params['searchTerm']) {
        this.searchTerm = params['searchTerm'];
      } else {
        this.searchTerm = '';
      }

      if (params['orderBy']) {
        this.orderBy = params['orderBy'];
      } else {
        this.orderBy = 'default';
      }

      this.apiService.fetchShopData(params, this.perPage).subscribe(result => {
        console.log(result.products);
        let productAPI: any[];
        // this.productService.findAll().subscribe(
        //   data => {
        //     productAPI = data.products.map(pro => {
        //       return {
        //         author: null,
        //         brands: [{name: 'UGG', slug: 'ugg', pivot: {product_id: '10', brand_id: '1'}}],
        //         category: {
        //           name: pro.category.categoryName,
        //           slug: pro.category.categoryName,
        //           pivot: {product_id: '10', brand_id: '1'}
        //         },
        //         featured: null,
        //         id: pro.productId,
        //         name: pro.productName,
        //         new: null,
        //         pictures: pro.images.map(img => {
        //           return {
        //             width: '800',
        //             height: '800',
        //             url: img.imageUrl,
        //             pivot: null
        //           }
        //         }),
        //         price: pro.productVariants[0].price,
        //         ratings: 5,
        //         review: 2,
        //         sale_price: null,
        //         short_desc: pro.description,
        //         slug: pro.productName,
        //         sm_pictures: pro.images.map(img => {
        //           return {
        //             width: '300',
        //             height: '300',
        //             url: img.imageUrl,
        //             pivot: null
        //           }
        //         }),
        //         sold: null,
        //         stock: 100,
        //         top: true,
        //         until: null,
        //         variants: pro.productVariants.map(vari => {
        //           return {
        //             color: vari.color,
        //             color_name:vari.color.colorName,
        //             id: 1,
        //             pivot: null,
        //             price: vari.price
        //           }
        //         }),

        //       }
        //     })
        //     console.log(productAPI)
        //   }
        // )
        this.products = result.products;
        this.totalCount = result.totalCount;

        this.loaded = true;
        if (!this.firstLoad) {
          this.firstLoad = true;
        }

        this.utilsService.scrollToPageContent();
      })
    })
  }

  ngOnInit(): void {
    if (window.innerWidth > 991) this.toggle = false;
    else this.toggle = true;
  }

  @HostListener('window: resize', ['$event'])
  onResize(event: Event) {
    if (window.innerWidth > 991) this.toggle = false;
    else this.toggle = true;
  }

  changeOrderBy(event: any) {
    this.router.navigate([], { queryParams: { orderBy: event.currentTarget.value, page: 1 }, queryParamsHandling: 'merge' });
  }

  toggleSidebar() {
    if (document.querySelector('body').classList.contains('sidebar-filter-active'))
      document.querySelector('body').classList.remove('sidebar-filter-active');
    else
      document.querySelector('body').classList.add('sidebar-filter-active');
  }

  hideSidebar() {
    document.querySelector('body').classList.remove('sidebar-filter-active');
  }
}
