import { Injectable } from '@angular/core';
import { Observable, of, Subject } from 'rxjs';
import { Order } from '../../models/order/order.model';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ModelResponse } from '../../models/response/ModelResponse';
import { Cart } from '../../models/cart/cart.model';

@Injectable({
  providedIn: 'root'
})
export class CartService {

  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient,
  ) {
  }

  findAll(): Observable<Cart> {
    const url: string = `${this.baseUrlService.baseURL}/cart`
    return this.httpClient.get<Cart>(url)
  }

  addToCart(productId: number): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/cart/add/${productId}`
    return this.httpClient.get<ModelResponse>(url)
  }

  removeFromCart(productId: number): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/cart/remove/${productId}`
    return this.httpClient.get<ModelResponse>(url)
  }

  isInCart(productId: number): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/cart/isInCart/${productId}`
    return this.httpClient.get<ModelResponse>(url)
  }

  getQuantity(): Observable<GetCartQuanitty> {
    const url: string = `${this.baseUrlService.baseURL}/cart/quantity`
    return this.httpClient.get<GetCartQuanitty>(url)
  }

}

export interface GetCartQuanitty {
  quantity: number
}
