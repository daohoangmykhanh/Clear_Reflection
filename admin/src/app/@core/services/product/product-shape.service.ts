import { Observable, of } from 'rxjs';
import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ProductShape } from '../../models/product/product-shape.model';
import { Product } from '../../models/product/product.model';
import { ModelResponse } from '../../models/response/ModelResponse';

@Injectable({
  providedIn: 'root'
})
export class ProductShapeService {

  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { }

  findAll(): Observable<ProductShape[] | ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/shape`
    return this.httpClient.get<ProductShape[]  | ModelResponse>(url)
  }

  insert(shape: ProductShape): Observable<ProductShape> {
    const url: string = `${this.baseUrlService.baseURL}/shape/create`
    return this.httpClient.post<ProductShape>(url, shape);
  }

  update(shape: ProductShape): Observable<boolean> {
    const url: string = `${this.baseUrlService.baseURL}/shape/update`
    return this.httpClient.post<boolean>(url, shape);
  }

  delete(shapeId: number): Observable<boolean> {    
    const url: string = `${this.baseUrlService.baseURL}/shape/delete/${shapeId}`
    return this.httpClient.delete<boolean>(url); 
  }
}
