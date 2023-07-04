import { Injectable } from '@angular/core';
import { BaseURLService } from '../base-url.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs-compat';
import { ProductCategory } from '../../models/product/product-category.model';
import { of, BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProductCategoryService {

  private stateSubject: BehaviorSubject<string> = new BehaviorSubject<string>('add');
  private rowDataSubject: BehaviorSubject<ProductCategory> = new BehaviorSubject<ProductCategory>(null);

  public state$: Observable<string> = this.stateSubject.asObservable();
  public rowData$: Observable<any> = this.rowDataSubject.asObservable();

  updateHandleAndRowData(state: string, rowData?: any) {
    // console.log("state: " + state + " - rowData: " );
    // console.dir(rowData)
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

  findAll(): Observable<ProductCategory[]> {
    // const url: string = `${this.categoryUrl}/category/findAll`
    // return this.httpClient.get<ProductCategory[]>(url)
    const cates: ProductCategory[] = [
      {
        categoryId: 1,
        categoryName: 'Category 1',
        imageUrl: 'assets/images/camera1.jpg',
      },
      {
        categoryId: 2,
        categoryName: 'Category 2',
        imageUrl: 'assets/images/camera2.jpg',
      },
      {
        categoryId: 3,
        categoryName: 'Category 3',
        imageUrl: 'assets/images/camera3.jpg',
      },
      {
        categoryId: 4,
        categoryName: 'Category 4',
        imageUrl: 'assets/images/camera4.jpg',
      },
      {
        categoryId: 5,
        categoryName: 'Category 5',
        imageUrl: 'assets/images/cover1.jpg',
      },
    ]
    return of(cates);
  }

  insert(category: ProductCategory): ProductCategory {
    return new ProductCategory()
  }

  edit(category: ProductCategory): boolean {
    return true
  }
}
