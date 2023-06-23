import { Component, OnInit } from '@angular/core';
import { LocalDataSource } from 'ng2-smart-table';
import { SmartTableService } from '../../../@core/services/smart-table.service';
import { Router } from '@angular/router';
import { Subject } from 'rxjs';

@Component({
  selector: 'ngx-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss']
})
export class ProductListComponent{
  private destroy$ = new Subject<void>();

  // Setting for List layout
  settings = {
    actions: {
      position: 'right'
    },
    mode: 'external', // when add/edit -> navigate to another url
    columns: {
      id: {
        title: 'ID',
        type: 'number',
      },
      firstName: {
        title: 'First Name',
        type: 'string',
      },
      lastName: {
        title: 'Last Name',
        type: 'string',
      },
      username: {
        title: 'Username',
        type: 'string',
      },
      email: {
        title: 'E-mail',
        type: 'string',
      },
      age: {
        title: 'Age',
        type: 'number',
      },
    },
    add: {
      addButtonContent: '<i class="nb-plus"></i>',
    },
    edit: {
      editButtonContent: '<i class="nb-edit"></i>',
    },
    delete: {
      deleteButtonContent: '<i class="nb-trash"></i>',
      confirmDelete: true,
    },
  };

  source: LocalDataSource = new LocalDataSource();

  constructor(
    private service: SmartTableService,
    private router: Router,
  ) {
    const data = this.service.getData();
    this.source.load(data);
  }
  
  

  onDeleteConfirm(event): void {
    if (window.confirm('Are you sure you want to delete?')) {
      event.confirm.resolve();
    } else {
      event.confirm.reject();
    }
  }

  onCreateProducts(): void {
    this.router.navigate(['/admin/products', 'add'], )
  }

  onEditProducts(event: any): void {
    const productId: string = event.data.id
    this.router.navigate(['/admin/products', 'edit', productId], )
  }

  getProductDetails(event: any): void {
    const productId: string = event.data.id
    this.router.navigate(['/admin/products', 'detail', productId], )
  }

  changeCursor(): void {
    const element = document.getElementById('product-table'); // Replace 'myElement' with the ID of your element
    if (element) {
      element.style.cursor = 'pointer';
    }
  }
}
