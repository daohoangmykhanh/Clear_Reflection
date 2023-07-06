import { Injectable } from '@angular/core';
import { Observable, of, BehaviorSubject } from 'rxjs';
import { Product } from '../../models/product/product.model';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';

export class ToastState {
  bahavior: String;
  model: string;
  status: string;
}
@Injectable({
  providedIn: 'root'
})
export class ProductService {
  constructor(
    private baseUrlService: BaseURLService,
    private httpClient: HttpClient
  ) { }

  findByNameKeyword(productName: string): Observable<Product[]>  {
    return of(null)
    // return of([
    //   {
    //     productId: 1,
    //     productName: 'Product Name 1',
    //     description: 'Description 1',
    //     isHide: false,
    //     category: {categoryId: 1, categoryName: 'Category 1', imageUrl: 'assets/images/alan.png'},
    //     productShape: {productShapeId: 1, shapeName: 'Shape 1'},
    //     tyle: {productStyleId: 1, styleName: 'Style 1'},
    //     createdAt: new Date(),
    //     updatedAt: new Date(),
    //     imageUrls: [
    //       'assets/images/camera1.jpg',
    //       'assets/images/camera2.jpg',
    //       'assets/images/camera3.jpg',
    //       'assets/images/camera4.jpg',
    //     ],
    //     quantitySold: 100,
    //     rating: 1,
    //     totalLikes: 100
    //   },
    //   {
    //     productId: 2,
    //     productName: 'Product Name 2',
    //     description: 'Description 2',
    //     isHide: true,
    //     category: {categoryId: 2, categoryName: 'Category 2', imageUrl: 'assets/images/alan.png'},
    //     shape: {productShapeId: 2, shapeName: 'Shape 2'},
    //     style: {productStyleId: 2, styleName: 'Style 2'},
    //     createdAt: new Date(),
    //     updatedAt: new Date(),
    //     imageUrls: [
    //       'assets/images/camera1.jpg',
    //       'assets/images/camera2.jpg',
    //       'assets/images/camera3.jpg',
    //       'assets/images/camera4.jpg',
    //     ],
    //     quantitySold: 200,
    //     rating: 2,
    //     totalLikes: 200
    //   }])
  }

  findAll(): Observable<Product[]> {
    const url = `${this.baseUrlService.baseURL}/product`
    return this.httpClient.get<Product[]>(url);
  }
  
  findById(id: number): Observable<Product | null>  {
    if(id >= 1 && id <= 10) {
      return of({
        productId: 1,
        productName: 'Product Name',
        description: 'Description',
        isHide: false,
        category: {categoryId: 1, categoryName: 'Category 1', imageUrl: 'assets/images/alan.png'},
        productShape: {productShapeId: 1, shapeName: 'Shape 1'},
        productStyle: {productStyleId: 1, styleName: 'Style 1'},
        createdAt: new Date(),
        updatedAt: new Date(),
        productVariants: [
          {productVariantId: 1, height: 10, width: 10, quantity: 10, price: 10, imageUrl: null, color: {productColorId: 1, colorName: 'Color 1'}},
          {productVariantId: 2, height: 20, width: 20, quantity: 20, price: 20, imageUrl: 'assets/images/cover2.jpg', color: {productColorId: 2, colorName: 'Color 2'}},
          {productVariantId: 3, height: 30, width: 30, quantity: 30, price: 30, imageUrl: 'assets/images/cover3.jpg', color: {productColorId: 3, colorName: 'Color 3g'}},
        ],
        imageUrls: [
          'assets/images/camera1.jpg',
          'assets/images/camera2.jpg',
          'assets/images/camera2.jpg',
          'assets/images/camera2.jpg',
        ]
      })
    } 
    return of(null)
  }

  insert(product: Product): Observable<Product> {
    const url: string = `${this.baseUrlService.baseURL}/product/create`
    return this.httpClient.post<Product>(url, product);
  }

  edit(product: Product): Observable<boolean> {
    const url: string = `${this.baseUrlService.baseURL}/product/update`
    return this.httpClient.post<boolean>(url, product);
  }

  delete(productId: number): Observable<boolean> {    
    const url: string = `${this.baseUrlService.baseURL}/product/delete/${productId}`
    return this.httpClient.delete<boolean>(url); 
  }
}
