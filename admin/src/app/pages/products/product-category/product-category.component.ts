import { Component, ViewChild, OnInit } from "@angular/core";
import { LocalDataSource } from "ng2-smart-table";
import { Router } from "@angular/router";
import { CustomCategoryActionComponent } from "./custom/custom-category-action.component";
import { CustomCategoryFilterActionsComponent } from "./custom/custom-category-filter-actions.component";
import { ProductCategory } from "../../../@core/models/product/product-category.model";
import { ProductCategoryService } from "../../../@core/services/product/product-category.service";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { CustomValidator } from "../../../@core/validators/custom-validator";
import { CustomCategoryImageComponent } from "./custom/custom-category-image.component";
import { ToastState, UtilsService } from "../../../@core/services/utils.service";

@Component({
  selector: "ngx-product-category",
  templateUrl: "./product-category.component.html",
  styleUrls: ["./product-category.component.scss"],
})
export class ProductCategoryComponent implements OnInit {
  state: string = "add"; // default
  
  addCategoryFormGroup: FormGroup;
  editCategoryFormGroup: FormGroup;
  // Setting for List layout
  numberOfItem: number = localStorage.getItem('itemPerPage') != null ? +localStorage.getItem('itemPerPage') : 10; // default
  source: LocalDataSource = new LocalDataSource();
  settings = {
    actions: {
      edit: false,
      delete: false,
      add: false,
      columnTitle: ''
    },
    mode: "external", // when add/edit -> navigate to another url
    columns: {
      imageUrl: {
        title: "Image",
        type: "custom",
        renderComponent: CustomCategoryImageComponent,
        sort: false,
        filter: false
      },
      categoryId: {
        title: "ID",
        type: "number",
      },
      categoryName: {
        title: "Name",
        type: "string",
      },
      actions: {
        title: 'Actions',
        type: 'custom',
        sort: false,
        filter: {
          type: 'custom',
          component: CustomCategoryFilterActionsComponent
        },
        renderComponent: CustomCategoryActionComponent
      }
    },
    pager: {
      display: true,
      perPage: this.numberOfItem
    },
  };

  constructor(
    private categoryService: ProductCategoryService,
    private formBuilder: FormBuilder,
    private utilsService: UtilsService,
    private router: Router
  ) {
    this.categoryService.findAll().subscribe(
      data => {
        this.source.load(data);
      }
    )
    this.addCategoryFormGroup = this.formBuilder.group({
      name: ['', [CustomValidator.notBlank, Validators.maxLength(100)]],
      imageUrl: [, [Validators.required]]
    })
    
    this.editCategoryFormGroup = this.formBuilder.group({
      id: [],
      name: ['', [CustomValidator.notBlank, Validators.maxLength(100)]],
      imageUrl: [, [Validators.required]]
    })

  }
  
  ngOnInit() {
    this.categoryService.state$.subscribe((state) => {
      this.state = state;
    });
  
    this.categoryService.rowData$.subscribe((rowData) => {
      if (rowData) {
        this.editCategoryFormGroup.get('id').setValue(rowData.categoryId);
        this.editCategoryFormGroup.get('name').setValue(rowData.categoryName);
        this.editCategoryFormGroup.get('imageUrl').setValue(rowData.imageUrl);
      }
    });
  }
  
  selectFile(event: any) {
    if(event.target.files) {
      const reader = new FileReader();
        reader.onload = (event: any) => {
          if(this.state == 'add') {
            this.addCategoryFormGroup.get('imageUrl').setValue(event.target.result)
          } else if (this.state == 'edit') {
            this.editCategoryFormGroup.get('imageUrl').setValue(event.target.result)
          }
        };
        reader.readAsDataURL(event.target.files[0]);
    }
  }

  changeCursor(): void {
    const element = document.getElementById("product-table"); // Replace 'myElement' with the ID of your element
    if (element) {
      element.style.cursor = "pointer";
    }
  }

  numberOfItemsChange() {
    localStorage.setItem('itemPerPage', this.numberOfItem.toString())
    this.source.setPaging(1, this.numberOfItem)
  }

  createCategory() {
    if(this.addCategoryFormGroup.invalid) {
      this.addCategoryFormGroup.markAllAsTouched();
      this.utilsService.updateToastState(new ToastState('add', 'category', 'danger'))
      return;
    }

    let category: ProductCategory = new ProductCategory()
    category.categoryName = this.addCategoryFormGroup.get('name').value
    category.imageUrl = this.addCategoryFormGroup.get('imageUrl').value
    if(this.categoryService.insert(category)) {
      this.utilsService.updateToastState(new ToastState('add', 'category', 'success'))
      this.addCategoryFormGroup.reset()
      this.router.navigate(['/admin/products/category'])
    }
  }

  editCategory() {
    if(this.editCategoryFormGroup.invalid) {
      this.editCategoryFormGroup.markAllAsTouched();
      this.utilsService.updateToastState(new ToastState('edit', 'category', 'danger'))
      return;
    }

    let category: ProductCategory = new ProductCategory()
    category.categoryId = this.editCategoryFormGroup.get('id').value
    category.categoryName = this.addCategoryFormGroup.get('name').value
    category.imageUrl = this.addCategoryFormGroup.get('imageUrl').value

    if(this.categoryService.edit(category)) {
      this.utilsService.updateToastState(new ToastState('edit', 'category', 'success'))
      this.categoryService.updateHandleAndRowData('add');
      this.router.navigate(['/admin/products/category'])
    }
  }
}
