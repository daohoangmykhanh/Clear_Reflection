import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Order } from '../../models/order/order.model';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { OrderStatus } from '../../models/order/order-status.model';
import { OrderStatusService } from './order-status.service';
import { PaymentMethodService } from './payment-method.service';

@Injectable({
  providedIn: 'root'
})
export class OrderService {
  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient,
    private orderStatusService: OrderStatusService,
    private paymentMethodService: PaymentMethodService
  ) { }

  // findAll(): Observable<Order[]> {
  //   return of([
  //     {
  //       orderId: 1,
  //       orderTrackingNumber: 'abcxyz',
  //       accountEmail: 'account1@gmail.com',
  //       totalPrice: 111,
  //       totalQuantity: 111,
  //       orderStatus: {
  //         orderStatusId: 1,
  //         statusName: 'Handling',
  //         statusDescription: 'The order are handling'
  //       },
  //       paymentMethod: {
  //         paymentMethodId: 1,
  //         paymentMethodName: 'Paypal',
  //       },
  //       createdAt: new Date(),
  //       updatedAt: new Date()
  //     },
  //     {
  //       orderId: 2,
  //       orderTrackingNumber: 'abcxyz2',
  //       accountEmail: 'account2@gmail.com',
  //       totalPrice: 222,
  //       totalQuantity: 222,
  //       orderStatus: {
  //         orderStatusId: 2,
  //         statusName: 'Delivering',
  //         statusDescription: 'The products of order are Delivering'
  //       },
  //       paymentMethod: {
  //         paymentMethodId: 2,
  //         paymentMethodName: 'Vnpay',
  //       },
  //       createdAt: new Date(),
  //       updatedAt: new Date()
  //     },
  //     {
  //       orderId: 3,
  //       orderTrackingNumber: 'abcxyz3',
  //       accountEmail: 'account1@gmail.com',
  //       totalPrice: 333,
  //       totalQuantity: 333,
  //       orderStatus: {
  //         orderStatusId: 1,
  //         statusName: 'Handling',
  //         statusDescription: 'The order are handling'
  //       },
  //       paymentMethod: {
  //         paymentMethodId: 1,
  //         paymentMethodName: 'Paypal',
  //       },
  //       createdAt: new Date(),
  //       updatedAt: new Date()
  //     },
  //     {
  //       orderId: 4,
  //       orderTrackingNumber: 'abcxyz4',
  //       accountEmail: 'account4@gmail.com',
  //       totalPrice: 444,
  //       totalQuantity: 444,
  //       orderStatus: {
  //         orderStatusId: 2,
  //         statusName: 'Delivering',
  //         statusDescription: 'The products of order are Delivering'
  //       },
  //       paymentMethod: {
  //         paymentMethodId: 2,
  //         paymentMethodName: 'Vnpay',
  //       },
  //       createdAt: new Date(),
  //       updatedAt: new Date()
  //     },
  //     {
  //       orderId: 5,
  //       orderTrackingNumber: 'abcxyz5',
  //       accountEmail: 'account1@gmail.com',
  //       totalPrice: 555,
  //       totalQuantity: 555,
  //       orderStatus: {
  //         orderStatusId: 1,
  //         statusName: 'Handling',
  //         statusDescription: 'The order are handling'
  //       },
  //       paymentMethod: {
  //         paymentMethodId: 1,
  //         paymentMethodName: 'Paypal',
  //       },
  //       createdAt: new Date(),
  //       updatedAt: new Date()
  //     },
  //   ])
  // }

  findById(id: number): Observable<Order> {
    if(id >= 1 && id <= 10) {
      return of(
        {
          orderId: 1,
          orderTrackingNumber: 'abcxyz',
          accountEmail: 'account1@gmail.com',
          totalPrice: 111,
          totalQuantity: 111,
          orderStatus: {
            orderStatusId: 1,
            statusName: 'Handling',
            statusDescription: 'The order are handling'
          },
          shippingAddress: {
            id: 1,
            houseNumber: '7A/95C',
            roadName: 'Ao Doi street',
          },
          paymentMethod: {
            paymentMethodId: 1,
            paymentMethodName: 'Paypal',
          },
          createdAt: new Date(),
          updatedAt: new Date(),
          orderDetails: [
            {orderDetailId: 1, productId: 1, height: 10, width: 10, color: {productColorId: 1, colorName: 'white'}, quantity: 10, price: 10, imageUrl: 'assets/images/camera1.jpg' },
            {orderDetailId: 2, productId: 2, height: 20, width: 20, color: {productColorId: 2, colorName: 'white'}, quantity: 20, price: 20, imageUrl: 'assets/images/camera2.jpg' },
            {orderDetailId: 3, productId: 3, height: 30, width: 30, color: {productColorId: 3, colorName: 'white'}, quantity: 30, price: 30, imageUrl: 'assets/images/camera3.jpg' },
            {orderDetailId: 4, productId: 4, height: 40, width: 40, color: {productColorId: 4, colorName: 'white'}, quantity: 40, price: 40, imageUrl: 'assets/images/camera4.jpg' },
          ]
        },
      )
    }
    return of(null)
  }

  findAll(): Observable<Order[]> {
    const url: string = `${this.baseUrlService.baseURL}/order`
    return this.httpClient.get<Order[]>(url)
  }

  insert(order: Order): Observable<Order> {
    const url: string = `${this.baseUrlService.baseURL}/order/create`
    return this.httpClient.post<Order>(url, order);
  }

  edit(order: Order): Observable<boolean> {
    const url: string = `${this.baseUrlService.baseURL}/order/update`
    return this.httpClient.post<boolean>(url, order);
  }

  delete(orderId: number): Observable<boolean> {    
    const url: string = `${this.baseUrlService.baseURL}/order/delete/${orderId}`
    return this.httpClient.delete<boolean>(url); 
  }
}
