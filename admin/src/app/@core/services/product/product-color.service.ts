import { Observable, of } from 'rxjs';
import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ProductColor } from '../../models/product/product-color.model';

@Injectable({
  providedIn: 'root'
})
export class ProductColorService {


  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) {
  }

  findAll(): Observable<ProductColor[]> {
    const url: string = `${this.baseUrlService.baseURL}/color`
    return this.httpClient.get<ProductColor[]>(url)
  }

  insert(color: ProductColor): Observable<ProductColor> {
    const url: string = `${this.baseUrlService.baseURL}/color/create`
    return this.httpClient.post<ProductColor>(url, color);
  }

  edit(color: ProductColor): Observable<boolean> {
    const url: string = `${this.baseUrlService.baseURL}/color/update`
    return this.httpClient.post<boolean>(url, color);
  }

  delete(colorId: number): Observable<boolean> {    
    const url: string = `${this.baseUrlService.baseURL}/color/delete/${colorId}`
    return this.httpClient.delete<boolean>(url); 
  }

  isBasicColor(color: ProductColor): boolean {
    return (color.productColorId >= 1 && color.productColorId <= 10)
  }
}
