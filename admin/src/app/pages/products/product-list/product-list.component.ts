import { Component, OnInit, AfterViewInit, ViewChild, ElementRef } from '@angular/core';
import { LocalDataSource } from 'ng2-smart-table';
import { SmartTableService } from '../../../@core/services/smart-table.service';
import { Router } from '@angular/router';
import { CustomActionComponent } from './custom/custom-action.component';
import { CustomFilterActionsComponent } from './custom/custom-filter-actions.component';
import { CustomFilterSoldComponent } from './custom/custom-filter-sold.component';

@Component({
  selector: 'ngx-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent implements AfterViewInit {
  numberOfItem: number = localStorage.getItem('itemPerPage') != null ? +localStorage.getItem('itemPerPage') : 10; // default
  source: LocalDataSource = new LocalDataSource();
  // Setting for List layout
  settings = {
    actions: {
      position: 'right',
      edit: false,
      delete: false,
      add: false,
      columnTitle: ''
    },
    columns: {
      id: {
        title: 'ID',
        type: 'number',
      },
      name: {
        title: 'Name',
        type: 'string',
      },
      category: {
        title: 'Category',
        filter: {
          type: 'list',
          config: {
            selectText: 'Category...',
            list: [
              { value: 'Glenna Reichert', title: 'Glenna Reichert' },
              { value: 'Kurtis Weissnat', title: 'Kurtis Weissnat' },
              { value: 'Chelsey Dietrich', title: 'Chelsey Dietrich' },
            ],
          },
        },
      },
      shape: {
        title: 'Shape',
        filter: {
          type: 'list',
          config: {
            selectText: 'Shape...',
            list: [
              { value: 'Glenna Reichert', title: 'Glenna Reichert' },
              { value: 'Kurtis Weissnat', title: 'Kurtis Weissnat' },
              { value: 'Chelsey Dietrich', title: 'Chelsey Dietrich' },
            ],
          },
        },
      },
      style: {
        title: 'Style',
        filter: {
          type: 'list',
          config: {
            selectText: 'Style...',
            list: [
              { value: 'Glenna Reichert', title: 'Glenna Reichert' },
              { value: 'Kurtis Weissnat', title: 'Kurtis Weissnat' },
              { value: 'Chelsey Dietrich', title: 'Chelsey Dietrich' },
            ],
          },
        },
      },
      sold: {
        title: 'Sold',
        filter: {
          type: 'custom',
          component: CustomFilterSoldComponent,
        },
      },
      rating: {
        title: 'Rating',
        type: 'number'
      },
      totalLikes: {
        title: 'Total Likes',
        type: 'number'
      },
      actions: {
        title: 'Actions',
        type: 'custom',
        sort: false,
        filter: {
          type: 'custom',
          component: CustomFilterActionsComponent,
        },
        renderComponent: CustomActionComponent
      }
    },
    pager: {
      display: true,
      perPage: this.numberOfItem
    },
  };


  constructor(
    private service: SmartTableService,
    private router: Router,
  ) {
    const data = this.service.getData();
    this.source.load(data);
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
