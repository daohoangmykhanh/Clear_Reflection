import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs-compat';
import { ProductCategory } from '../../models/product/product-category.model';
import { of, BehaviorSubject } from 'rxjs';
import { Coupon } from '../../models/coupon.model';
import { CouponType } from '../../models/coupon-type.model';

@Injectable({
  providedIn: 'root'
})
export class ProductCouponService {

  private stateSubject: BehaviorSubject<string> = new BehaviorSubject<string>('add');
  private rowDataSubject: BehaviorSubject<Coupon> = new BehaviorSubject<Coupon>(null);

  public state$: Observable<string> = this.stateSubject.asObservable();
  public rowData$: Observable<Coupon> = this.rowDataSubject.asObservable();

  updateHandleAndRowData(state: string, rowData?: any) {
    console.log("state: " + state + " - rowData: " );
    console.dir(rowData)
    this.stateSubject.next(state);
    if(rowData != undefined) {
      this.rowDataSubject.next(rowData as Coupon); 
    }
  }
  
  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { 
  }

  findAll(): Observable<Coupon[]> {
    // const url: string = `${this.categoryUrl}/category/findAll`
    // return this.httpClient.get<ProductCategory[]>(url)
    const coupons: Coupon[] = [
      {
        couponId: 1,
        code: 'CouponXX1',
        discount: 50,
        couponType: this.findCouponTypeById(1),
        description: 'Description 1',
        createdAt: '12/16/2023',
        expiredAt: '12/16/2023'
      },
      {
        couponId: 2,
        code: 'CouponXX2',
        discount: 20,
        couponType: this.findCouponTypeById(2),
        description: 'Description 2',
        createdAt: '12/16/2003',
        expiredAt: '12/16/2023'
      },
      {
        couponId: 3,
        code: 'CouponXX3',
        discount: 30,
        couponType: this.findCouponTypeById(1),
        description: 'Description 1',
        createdAt: '12/16/2023',
        expiredAt: '12/16/2023'
      },
      {
        couponId: 4,
        code: 'CouponXX4',
        discount: 4,
        couponType: this.findCouponTypeById(2),
        description: 'Description 4',
        createdAt: '12/16/2023',
        expiredAt: '12/16/2023'
      },
      {
        couponId: 5,
        code: 'CouponXX5',
        discount: 50,
        couponType: this.findCouponTypeById(1),
        description: 'Description 1',
        createdAt: '12/16/2023',
        expiredAt: '12/16/2023'
      },
    ]
    return of(coupons);
  }

  findCouponTypeById(id: number): CouponType {
    if(id == 1) {
      return { couponTypeId: 1, couponTypeName: 'percent' }
    } else {
      return { couponTypeId: 2, couponTypeName: 'fixed' }
    }
  }
  findAllCouponType(): Observable<CouponType[]> {
    return of(
      [{ couponTypeId: 1, couponTypeName: 'percent' },
      { couponTypeId: 2, couponTypeName: 'fixed' }]
    )
  }

  insert(coupon: Coupon): Coupon {
    return new Coupon()
  }

  edit(coupon: Coupon): boolean {
    return true;
  }


}
