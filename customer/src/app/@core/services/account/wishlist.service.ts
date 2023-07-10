import { Injectable } from '@angular/core';
import { Observable, of, Subject } from 'rxjs';
import { Order } from '../../models/order/order.model';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { Account } from '../../models/account/account.model';
import { OrderService } from '../order/order.service';
import { Address } from '../../models/address/address.model';
import { Province } from '../../models/address/provinces.model';
import { District } from '../../models/address/districts.model';
import { Ward } from '../../models/address/wards.model';
import { Image } from '../../models/Image';
import { ModelResponse } from '../../models/response/ModelResponse';
import { Wishlist } from '../../models/account/wishlist.model';

@Injectable({
  providedIn: 'root'
})
export class WishlistService {

  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient,
  ) {
  }

  findAll(): Observable<Wishlist[]> {
    const url: string = `${this.baseUrlService.baseURL}/wishlist`
    return this.httpClient.get<Wishlist[]>(url)
  }

  addToWishlist(productId: number): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/wishlist/add/${productId}`
    return this.httpClient.get<ModelResponse>(url)
  }

  removeFromWishlist(productId: number): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/wishlist/remove/${productId}`
    return this.httpClient.get<ModelResponse>(url)
  }

  isInWishlist(productId: number): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/wishlist/isInWishlist/${productId}`
    return this.httpClient.get<ModelResponse>(url)
  }

  getQuantity(): Observable<GetWistlistQuanitty> {
    const url: string = `${this.baseUrlService.baseURL}/wishlist/quantity`
    return this.httpClient.get<GetWistlistQuanitty>(url)
  }

}


export interface GetWistlistQuanitty {
  quantity: number
}
