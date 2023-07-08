import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs-compat';
import { ProductCategory } from '../../models/product/product-category.model';
import { of, BehaviorSubject, Subject } from 'rxjs';
import { CouponType } from '../../models/coupon/coupon-type.model';
import { Coupon } from '../../models/coupon/coupon.model';
import { ModelResponse } from '../../models/response/ModelResponse';

@Injectable({
  providedIn: 'root'
})
export class ProductCouponService {

  // for update state & rowDate and change between add & edit form
  private stateSubject: BehaviorSubject<string> = new BehaviorSubject<string>('add');
  private rowDataSubject: BehaviorSubject<Coupon> = new BehaviorSubject<Coupon>(null);

  public state$: Observable<string> = this.stateSubject.asObservable();
  public rowData$: Observable<Coupon> = this.rowDataSubject.asObservable();

  updateHandleAndRowData(state: string, rowData?: any) {
    this.stateSubject.next(state);
    if(rowData != undefined) {
      this.rowDataSubject.next(rowData as Coupon); 
    }
  }

  // for changing when create, edit, delete => reload
  private couponChangeSubject = new Subject<void>();

  get couponChange$(): Observable<void> {
    return this.couponChangeSubject.asObservable();
  }

  notifyCouponChange(): void {
    this.couponChangeSubject.next();
  }

  
  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { 
  }

  // findAll(): Observable<Coupon[]> {
  //   // const url: string = `${this.categoryUrl}/category/findAll`
  //   // return this.httpClient.get<ProductCategory[]>(url)
  //   const coupons: Coupon[] = [
  //     {
  //       couponId: 1,
  //       code: 'CouponXX1',
  //       discount: 50,
  //       couponType: this.findCouponTypeById(1),
  //       description: 'Description 1',
  //       createdAt: new Date(),
  //       expiredAt: new Date()
  //     },
  //     {
  //       couponId: 2,
  //       code: 'CouponXX2',
  //       discount: 20,
  //       couponType: this.findCouponTypeById(2),
  //       description: 'Description 2',
  //       createdAt: new Date(),
  //       expiredAt: new Date()
  //     },
  //     {
  //       couponId: 3,
  //       code: 'CouponXX3',
  //       discount: 30,
  //       couponType: this.findCouponTypeById(1),
  //       description: 'Description 1',
  //       createdAt: new Date(),
  //       expiredAt: new Date()
  //     },
  //     {
  //       couponId: 4,
  //       code: 'CouponXX4',
  //       discount: 4,
  //       couponType: this.findCouponTypeById(2),
  //       description: 'Description 4',
  //       createdAt: new Date(),
  //       expiredAt: new Date()
  //     },
  //     {
  //       couponId: 5,
  //       code: 'CouponXX5',
  //       discount: 50,
  //       couponType: this.findCouponTypeById(1),
  //       description: 'Description 1',
  //       createdAt: new Date(),
  //       expiredAt: new Date()
  //     },
  //   ]
  //   return of(coupons);
  // }

  findAll(): Observable<Coupon[] | ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/coupon`
    return this.httpClient.get<Coupon[] | ModelResponse>(url)
  }

  insert(coupon: Coupon): Observable<Coupon> {
    const url: string = `${this.baseUrlService.baseURL}/coupon/create`
    return this.httpClient.post<Coupon>(url, coupon);
  }

  update(coupon: Coupon): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/coupon/update/${coupon.couponId}`
    console.log(url);
    
    return this.httpClient.post<ModelResponse>(url, coupon);
  }

  delete(couponId: number): Observable<ModelResponse> {    
    const url: string = `${this.baseUrlService.baseURL}/coupon/delete/${couponId}`
    return this.httpClient.get<ModelResponse>(url); 
  }

  findCouponTypeById(id: number): CouponType {
    if(id == 1) {
      return { couponTypeId: 1, couponTypeName: 'percent' }
    } else {
      return { couponTypeId: 2, couponTypeName: 'fixed' }
    }
  }
  findAllCouponType(): Observable<CouponType[]> {
    const url: string = `${this.baseUrlService.baseURL}/coupon-detail`
    return this.httpClient.get<CouponType[]>(url)
  }
}
