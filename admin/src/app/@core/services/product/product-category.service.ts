import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs-compat';
import { ProductCategory } from '../../models/product/product-category.model';
import { of, BehaviorSubject } from 'rxjs';
import { ModelResponse } from '../../models/response/ModelResponse';

@Injectable({
  providedIn: 'root'
})
export class ProductCategoryService {

  private stateSubject: BehaviorSubject<string> = new BehaviorSubject<string>('add');
  private rowDataSubject: BehaviorSubject<ProductCategory> = new BehaviorSubject<ProductCategory>(null);

  public state$: Observable<string> = this.stateSubject.asObservable();
  public rowData$: Observable<any> = this.rowDataSubject.asObservable();

  updateHandleAndRowData(state: string, rowData?: any) {
    this.stateSubject.next(state);
    if(rowData != undefined) {
      this.rowDataSubject.next(rowData as ProductCategory); 
    }
  }
  
  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { 
  }

  findAll(): Observable<ProductCategory[]  | ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/category`
    return this.httpClient.get<ProductCategory[]  | ModelResponse>(url)
  }

  insert(category: ProductCategory): Observable<ProductCategory> {
    const url: string = `${this.baseUrlService.baseURL}/category/create`
    return this.httpClient.post<ProductCategory>(url, category);
  }

  edit(category: ProductCategory): Observable<boolean> {
    const url: string = `${this.baseUrlService.baseURL}/category/update`
    return this.httpClient.post<boolean>(url, category);
  }

  delete(categoryId: number): Observable<boolean> {    
    const url: string = `${this.baseUrlService.baseURL}/category/delete/${categoryId}`
    return this.httpClient.delete<boolean>(url); 
  }
}
