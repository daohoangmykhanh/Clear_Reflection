import { Injectable } from '@angular/core';
import { Observable, of, BehaviorSubject } from 'rxjs';
import { Product } from '../../models/product/product.model';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { ModelResponse } from '../../models/response/ModelResponse';

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

  findAll(): Observable<Product[] | ModelResponse> {
    const url = `${this.baseUrlService.baseURL}/product`
    return this.httpClient.get<Product[] | ModelResponse>(url);
  }
  
  findById(id: number): Observable<Product | ModelResponse>  {
    const url: string = `${this.baseUrlService.baseURL}/product/${id}`
    return this.httpClient.get<Product>(url);
  } 

  findDetailById(id: number): Observable<Product | ModelResponse>  {
    const url: string = `${this.baseUrlService.baseURL}/product/detail/${id}`
    return this.httpClient.get<Product>(url);
  } 

  insert(product: Product): Observable<Product> {
    const url: string = `${this.baseUrlService.baseURL}/product/create`
    return this.httpClient.post<Product>(url, product);
  }

  update(product: Product): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/product/update/${product.productId}`
    return this.httpClient.post<ModelResponse>(url, product);
  }

  delete(productId: number): Observable<ModelResponse> {    
    const url: string = `${this.baseUrlService.baseURL}/product/delete/${productId}`
    return this.httpClient.delete<ModelResponse>(url); 
  }

  hideProduct(productId: number): Observable<ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/product/hideProduct/${productId}`
    return this.httpClient.get<ModelResponse>(url); 
  }

  getDetails(productId: number): Observable<Product | ModelResponse> {
    const url: string = `${this.baseUrlService.baseURL}/product/details1/${productId}`;
    return this.httpClient.get<ModelResponse >(url)
  }
}
