import { Observable, of } from 'rxjs';
import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ProductStyle } from '../../models/product/product-style.model';
import { ModelResponse } from '../../models/response/ModelResponse';

@Injectable({
  providedIn: 'root'
})
export class ProductStyleService {


  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { 
  }

  findAll(): Observable<ProductStyle[] | ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/style`
    return this.httpClient.get<ProductStyle[]  | ModelResponse>(url)
  }

  insert(style: ProductStyle): Observable<ProductStyle> {
    const url: string = `${this.baseUrlService.baseURL}/style/create`
    return this.httpClient.post<ProductStyle>(url, style);
  }

  edit(style: ProductStyle): Observable<boolean> {
    const url: string = `${this.baseUrlService.baseURL}/style/update`
    return this.httpClient.post<boolean>(url, style);
  }

  delete(styleId: number): Observable<boolean> {    
    const url: string = `${this.baseUrlService.baseURL}/style/delete/${styleId}`
    return this.httpClient.delete<boolean>(url); 
  }
}
