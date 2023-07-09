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

@Injectable({
  providedIn: 'root'
})
export class AccountService {

  // for changing when create, edit, delete => reload
  private accountChangeSubject = new Subject<void>();

  get accountChange$(): Observable<void> {
    return this.accountChangeSubject.asObservable();
  }

  notifyAccountChange(): void {
    this.accountChangeSubject.next();
  }


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

  findByEmailKeyword(emailKeyword: string): Observable<Account[] | ModelResponse> {
    return of([
      {
        accountId: 1,
        fullName: 'Đào Hoàng Mỹ Khánh',
        email: 'daohoangmykhanh@gmail.com',
        phoneNumber: '0123456789',
        image: {imageId: 1, imageUrl: 'assets/images/eva.png'},
        createdAt: new Date(),
        updatedAt: new Date()
      },
    ])
  }

  findAll(): Observable<Account[] | ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/account`
    return this.httpClient.get<Account[]  | ModelResponse>(url)
  }

  findById(id: number): Observable<Account> {
    const url: string = `${this.baseUrlService.baseURL}/account/detail/${id}`
    return this.httpClient.get<Account>(url);
  }

  insert(account: Account): Observable<Account> {
    const url: string = `${this.baseUrlService.baseURL}/account/create`
    return this.httpClient.post<Account>(url, account);
  }

  update(account: Account): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/account/update/${account.accountId}`
    return this.httpClient.post<ModelResponse>(url, account);
  }

  delete(accountId: number): Observable<ModelResponse> {    
    const url: string = `${this.baseUrlService.baseURL}/aroduct/delete/${accountId}`
    return this.httpClient.get<ModelResponse>(url); 
  }

  findByEmail(email: string): Observable<Account | null> {
    if(email == 'daohoangmykhanh@gmail.com') {
      return of(new Account());
    }
    return of(null)
  }

  findAllAddress(): Observable<Address[]> {
    const url: string = `${this.baseUrlService.baseURL}/address`
    return this.httpClient.get<Address[]>(url)
  }

  findAllDistrictByProvince(province: Province): Observable<District[]> {
    const url: string = `${this.baseUrlService.baseURL}/account/findAllDistrict/${province.code}`
    return this.httpClient.get<District[]>(url);
  }

  
  findAllWardByDistrict(ward: Ward): Observable<Ward[]> {
    const url: string = `${this.baseUrlService.baseURL}/account/findAllWard/${ward.code}`
    return this.httpClient.get<Ward[]>(url);
  }

  insertAddress(address: Address): Observable<Address> {
    const url: string = `${this.baseUrlService.baseURL}/account/insertAddress`
    return this.httpClient.post<Address>(url, address);
  }
}
