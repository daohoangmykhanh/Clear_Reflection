import { Component } from '@angular/core';
import { LocalDataSource } from 'ng2-smart-table';
import { SmartTableService } from '../../../@core/services/smart-table.service';
import { Router } from '@angular/router';

@Component({
  selector: 'ngx-customer-list',
  templateUrl: './customer-list.component.html',
  styleUrls: ['./customer-list.component.scss']
})
export class CustomerListComponent {
  settings = {
    actions: {
      position: 'right',
      delete: false
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
    this.router.navigate(['/admin/orders', 'add'], )
  }

  onEditProducts(event: any): void {
    const orderId: string = event.data.id
    this.router.navigate(['/admin/orders', 'edit', orderId], )
  }

  getProductDetails(event: any): void {
    const orderId: string = event.data.id
    this.router.navigate(['/admin/orders', 'detail', orderId], )
  }

  changeCursor(): void {
    const element = document.getElementById('order-table'); // Replace 'myElement' with the ID of your element
    if (element) {
      element.style.cursor = 'pointer';
    }
  }
}
