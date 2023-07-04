import { Observable, of } from 'rxjs';
import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ProductStyle } from '../../models/product/product-style.model';
import { ProductShape } from '../../models/product/product-shape.model';

@Injectable({
  providedIn: 'root'
})
export class ProductStyleService {

  styleUrl: string;

  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { 
    this.styleUrl = `${baseUrlService.baseURL}`
  }

  findAll(): Observable<ProductStyle[]> {
    // const url: string = `${this.styleUrl}/category/findAll`
    // return this.httpClient.get<ProductStyle[]>(url)
    const cates: ProductStyle[] = [
      {
        productStyleId: 1,
        styleName: 'Style 1',
      },
      {
        productStyleId: 2,
        styleName: 'Style 2',
      },
      {
        productStyleId: 3,
        styleName: 'Style 3',
      },
      {
        productStyleId: 4,
        styleName: 'Style 4',
      },
      {
        productStyleId: 5,
        styleName: 'Style 5',
      },
    ]
    return of(cates);
  }
}
