import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Order } from '../../models/order/order.model';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { Account } from '../../models/account/account.model';
import { OrderService } from '../order/order.service';

@Injectable({
  providedIn: 'root'
})
export class AccountService {
  orders: Order[]
  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient,
    private orderService: OrderService
  ) { 
    this.orderService.findAll().subscribe(
      data => this.orders = data
    )
  }

  findByEmailKeyword(emailKeyword: string): Observable<Account[]> {
    return of([
      {
        accountId: 1,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
    ])
  }

  findAll(): Observable<Account[]> {
    return of([
      {
        accountId: 1,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 2,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 3,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 4,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 5,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 6,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      }, {
        accountId: 7,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 8,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 9,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 10,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 11,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 12,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      }, {
        accountId: 13,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 14,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 15,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      }, {
        accountId: 16,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 17,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 18,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      }, {
        accountId: 19,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 20,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 21,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      }, {
        accountId: 22,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 23,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 24,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      }, {
        accountId: 25,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 26,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 27,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      }, {
        accountId: 28,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/eva.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 29,
        fullName: 'Nguyễn Phi Hùng',
        email: 'hungn12333@gmail.com',
        phoneNumber: '0123456789',
        imageUrl: 'assets/images/alan.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        accountId: 30,
        fullName: 'Nguyễn Mạnh Phú',
        email: 'nguyenphu1147@gmail.com',
        phoneNumber: '0783562372',
        imageUrl: 'assets/images/jack.png',
        createdAt: new Date(),
        updatedAt: new Date()
      },
    ])
  }

  findById(id: number): Observable<Account> {
    if(id >= 0 && id <= 10) {
      return of(
        {
          accountId: 1,
          fullName: 'Đào Hoàng Mỹ Khánh',
          email: 'daohoangmykhanh@gmail.com',
          phoneNumber: '0123456789',
          imageUrl: 'assets/images/eva.png',
          createdAt: new Date(),
          updatedAt: new Date(),
          orders: this.orders
        },
      )
    }
    return null
  }

  findByEmail(email: string): Observable<Account | null> {
    if(email == 'daohoangmykhanh@gmail.com') {
      return of(new Account());
    }
    return of(null)
  }



  insert(order: Order): Order {
    return new Order()
  }

  edit(product: Order): boolean {
    return true;
  }
}
