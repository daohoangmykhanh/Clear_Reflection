import { Observable, of } from 'rxjs';
import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ProductColor } from '../../models/product/product-color.model';

@Injectable({
  providedIn: 'root'
})
export class ProductColorService {

  shapeUrl: string;

  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { 
    this.shapeUrl = `${baseUrlService.baseURL}`
  }

  findAll(): Observable<ProductColor[]> {
    // const url: string = `${this.shapeUrl}/category/findAll`
    // return this.httpClient.get<ProductCategory[]>(url)
    const cates: ProductColor[] = [
      {
        productColorId: 1,
        colorName: 'Color 1',
      },
      {
        productColorId: 2,
        colorName: 'Color 2',
      },
      {
        productColorId: 3,
        colorName: 'Color 3',
      },
      {
        productColorId: 4,
        colorName: 'Color 4',
      },
      {
        productColorId: 5,
        colorName: 'Color 5',
      },
    ]
    return of(cates);
  }

  isBasicColor(color: ProductColor): boolean {
    return (color.productColorId >= 1 && color.productColorId <= 10)
  }
}
