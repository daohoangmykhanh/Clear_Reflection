import { Observable, of } from 'rxjs';
import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ProductShape } from '../../models/product/product-shape.model';

@Injectable({
  providedIn: 'root'
})
export class ProductShapeService {

  shapeUrl: string;

  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { 
    this.shapeUrl = `${baseUrlService.baseURL}`
  }

  findAll(): Observable<ProductShape[]> {
    // const url: string = `${this.shapeUrl}/category/findAll`
    // return this.httpClient.get<ProductCategory[]>(url)
    const cates: ProductShape[] = [
      {
        productShapeId: 1,
        shapeName: 'Shape 1',
      },
      {
        productShapeId: 2,
        shapeName: 'Shape 2',
      },
      {
        productShapeId: 3,
        shapeName: 'Shape 3',
      },
      {
        productShapeId: 4,
        shapeName: 'Shape 4',
      },
      {
        productShapeId: 5,
        shapeName: 'Shape 5',
      },
    ]
    return of(cates);
  }
}
