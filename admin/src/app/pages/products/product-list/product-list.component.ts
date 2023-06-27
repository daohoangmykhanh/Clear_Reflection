import { Component, OnInit, AfterViewInit, ViewChild, ElementRef } from '@angular/core';
import { LocalDataSource } from 'ng2-smart-table';
import { Router } from '@angular/router';
import { CustomProductActionComponent } from './custom/custom-product-action.component';
import { CustomProductFilterActionsComponent } from './custom/custom-product-filter-actions.component';
import { ProductService } from '../../../@core/services/product/product.service';
import { ProductCategoryService } from '../../../@core/services/product/product-category.service';
import { ProductShapeService } from '../../../@core/services/product/product-shape.service';
import { ProductStyleService } from '../../../@core/services/product/product-style.service';
import { ProductColorService } from '../../../@core/services/product/product-color.service';
import { ProductShape } from '../../../@core/models/product/product-shape.model';
import { ProductColor } from '../../../@core/models/product/product-color.model';
import { ProductStyle } from '../../../@core/models/product/product-style.model';
import { ProductCategory } from '../../../@core/models/product/product-category.model';
import { CustomCategoryImageComponent } from '../product-category/custom/custom-category-image.component';
import { NbGlobalLogicalPosition, NbGlobalPhysicalPosition, NbGlobalPosition, NbToastrService } from '@nebular/theme';

@Component({
  selector: 'ngx-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent implements OnInit, AfterViewInit {
  numberOfItem: number = localStorage.getItem('itemPerPage') != null ? +localStorage.getItem('itemPerPage') : 10; // default
  source: LocalDataSource = new LocalDataSource();
  // Setting for List layout
  shapes: ProductShape[];
  colors: ProductColor[];
  styles: ProductStyle[];
  categories: ProductCategory[];

  settings = {};


  constructor(
    private productService: ProductService,
    private router: Router,
    private categoryService: ProductCategoryService,
    private shapeService: ProductShapeService,
    private styleService: ProductStyleService,
    private colorService: ProductColorService,
    private toastService: NbToastrService
  ) {
    this.categoryService.findAll().subscribe(data => this.categories = data)
    this.shapeService.findAll().subscribe(data => this.shapes = data)
    this.colorService.findAll().subscribe(data => this.colors = data)
    this.styleService.findAll().subscribe(data => this.styles = data)
    this.settings = {
      actions: {
        position: 'right',
        edit: false,
        delete: false,
        add: false,
        columnTitle: ''
      },
      columns: {
        productId: {
          title: 'ID',
          type: 'number',
          width: '3%'
        },
        image: {
          title: 'Image',
          type: 'custom',
          sort: false,
          filter: false,
          renderComponent: CustomCategoryImageComponent
        },
        productName: {
          title: 'Name',
          type: 'string',
        },
        category: {
          title: 'Category',
          type: 'string',
          filter: {
            type: 'list',
            config: {
              selectText: 'Category...',
              list: this.categories.map(cate => {
                return { value: cate.categoryName, title: cate.categoryName}
              }) ,
            },
          },
        },
        shape: {
          title: 'Shape',
          type: 'string',
          filter: {
            type: 'list',
            config: {
              selectText: 'Shape...',
              list: this.shapes.map(shape => {
                return { value: shape.shapeName, title: shape.shapeName}
              }) ,
            },
          },
        },
        style: {
          title: 'Style',
          type: 'string',
          filter: {
            type: 'list',
            config: {
              selectText: 'Style...',
              list: this.styles.map(style => {
                return { value: style.styleName, title: style.styleName}
              }) 
              // [
              //   { value: 'Glenna Reichert', title: 'Glenna Reichert' },
              //   { value: 'Kurtis Weissnat', title: 'Kurtis Weissnat' },
              //   { value: 'Chelsey Dietrich', title: 'Chelsey Dietrich' },
              // ],
            },
          },
        },
        quantitySold: {
          title: 'Sold',
          type: 'number',
          width: '5%'
        },
        totalLikes: {
          title: 'Likes',
          type: 'number',
          width: '5%'
        },
        rating: {
          title: 'Rating',
          type: 'number',
          width: '3%'
        },
        actions: {
          title: 'Actions',
          type: 'custom',
          sort: false,
          filter: {
            type: 'custom',
            component: CustomProductFilterActionsComponent,
          },
          renderComponent: CustomProductActionComponent
        }
      },
      pager: {
        display: true,
        perPage: this.numberOfItem
      },
    }
    this.productService.findAll().subscribe(
      data => {
        const mappedProducts: any[] = data.map(pro => {
          return {
            productId: pro.productId,
            productName: pro.productName,
            isHide: pro.isHide,
            category: pro.category.categoryName,
            shape: pro.shape.shapeName,
            style: pro.style.styleName,
            image: pro.imageUrls[0],
            quantitySold: pro.quantitySold,
            totalLikes: pro.totalLikes,
            rating: pro.rating
          }
        })
        this.source.load(mappedProducts)
      }

    )
    // this.productService.toastState$.subscribe(state => {
    //   if(state == 'editSuccess') {
    //     this.toastService.show('Notification', `Edit Product Successfully`, {status: 'success', duration: 3000});
    //   } 
    // })
  }

  
  physicalPositions = NbGlobalPhysicalPosition;
  logicalPositions = NbGlobalLogicalPosition;
  ngOnInit(): void {
    let x;
  }
  
  ngAfterViewInit() {
    const pager = document.querySelector('ng2-smart-table-pager');
    pager.classList.add('d-block')
  }

  onDeleteConfirm(event): void {
    if (window.confirm('Are you sure you want to delete?')) {
      event.confirm.resolve();
    } else {
      event.confirm.reject();
    }
  }

  onCreate(): void {
    this.router.navigate(['/admin/products', 'add'],)
  }

  onEdit(event: any): void {
    const productId: string = event.data.id
    this.router.navigate(['/admin/products', 'edit', productId],)
  }

  getDetails(event: any): void {
    const productId: string = event.data.id
    this.router.navigate(['/admin/products', 'detail', productId],)
  }

  changeCursor(): void {
    const element = document.getElementById('product-table'); // Replace 'myElement' with the ID of your element
    if (element) {
      element.style.cursor = 'pointer';
    }
  }

  numberOfItemsChange() {
    localStorage.setItem('itemPerPage', this.numberOfItem.toString())
    this.source.setPaging(1, this.numberOfItem)
  }
}
