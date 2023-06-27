import { ProductCouponService } from './../../../@core/services/product/product-coupon.service';
import { Component, OnInit } from "@angular/core";
import { LocalDataSource } from "ng2-smart-table";
import { SmartTableService } from "../../../@core/services/smart-table.service";
import { Router } from "@angular/router";
import { NbComponentStatus } from "@nebular/theme";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ProductCategory } from "../../../@core/models/product/product-category.model";
import { CustomCouponFilterActionsComponent } from "./custom/custom-coupon-filter-actions.component";
import { CustomCouponActionComponent } from "./custom/custom-coupon-action.component";
import { ProductCategoryService } from "../../../@core/services/product/product-category.service";
import { CustomValidator } from "../../../@core/validators/custom-validator";
import { CustomCouponDiscountActionComponent } from './custom/custom-coupon-discount-action.component';
import { Coupon } from '../../../@core/models/coupon.model';
import { ToastState, UtilsService } from '../../../@core/services/utils.service';

@Component({
  selector: "ngx-products-coupon",
  templateUrl: "./product-coupon.component.html",
  styleUrls: ["./product-coupon.component.scss"],
})
export class ProductCouponComponent implements OnInit{
  state: string = "add"; // default
  selectedDiscountTypeAddForm;
  selectedDiscountTypeEditForm;
  addCouponFormGroup: FormGroup;
  editCouponFormGroup: FormGroup;
  
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
      couponId: {
        title: "ID",
        type: "number",
        width: '3%'
      },
      code: {
        title: "Code",
        type: "string",
      },
      description: {
        title: "Description",
        type: "string",
      },
      discount: {
        title: "Discount",
        type: 'custom',
        renderComponent: CustomCouponDiscountActionComponent
      },
      createdAt: {
        title: 'Start Date',
        type: 'string'
      },
      expiredAt: {
        title: 'Expired Date',
        type: 'string'
      },
      actions: {
        title: 'Actions',
        type: 'custom',
        sort: false,
        filter: {
          type: 'custom',
          component: CustomCouponFilterActionsComponent
        },
        renderComponent: CustomCouponActionComponent
      }
    },
    pager: {
      display: true,
      perPage: this.numberOfItem
    },
  };

  constructor(
    private couponService: ProductCouponService,
    private formBuilder: FormBuilder,
    private utilsService: UtilsService,
    private router: Router
  ) {
    this.addCouponFormGroup = this.formBuilder.group({
      code: ['', [CustomValidator.notBlank, Validators.maxLength(20)]],
      description: ['', [CustomValidator.notBlank, Validators.maxLength(50)]],
      discountType: ['', [Validators.required]],
      discountValue: [, [Validators.required, CustomValidator.maxCouponValue]],
      startedDate: [, Validators.required],
      expiredDate: [, Validators.required]
    })
    
    this.editCouponFormGroup = this.formBuilder.group({
      id: [],
      code: ['', [CustomValidator.notBlank, Validators.maxLength(20)]],
      description: ['', [CustomValidator.notBlank, Validators.maxLength(50)]],
      discountType: ['', [Validators.required]],
      discountValue: [, [Validators.required, CustomValidator.maxCouponValue]],
      startedDate: [, Validators.required],
      expiredDate: [, Validators.required]
    })
  }
  
  ngOnInit() {
    this.couponService.findAll().subscribe(
      data => {this.source.load(data)}
    )
    // Set the initial max value based on the default discountType
    this.couponService.state$.subscribe((state) => {
      this.state = state;
    });
    // receive data when edit 
    this.couponService.rowData$.subscribe((rowData) => {
      if(rowData) {
        this.editCouponFormGroup.get('id').setValue(rowData.couponId)
        this.editCouponFormGroup.get('code').setValue(rowData.code)
        this.editCouponFormGroup.get('description').setValue(rowData.couponId)
        if(rowData.couponType.couponTypeName == 'percent') {
          this.editCouponFormGroup.get('discountType').setValue('Percent')
          this.selectedDiscountTypeEditForm = 'Percent'
        } else {
          this.editCouponFormGroup.get('discountType').setValue('Fixed')
          this.selectedDiscountTypeEditForm = 'Fixed'
        }
        this.editCouponFormGroup.get('discountValue').setValue(rowData.discount)
        this.editCouponFormGroup.get('startedDate').setValue(rowData.createdAt)
        this.editCouponFormGroup.get('expiredDate').setValue(rowData.expiredAt)
      }
    });
  }

  submitAddCoupon() {
    if(this.addCouponFormGroup.invalid) {
      this.addCouponFormGroup.markAllAsTouched();
      this.utilsService.updateToastState(new ToastState('add', 'coupon', 'danger'))
      return;
    }

    let coupon: Coupon = new Coupon();
    coupon.code = this.addCouponFormGroup.get('code').value
    coupon.description = this.addCouponFormGroup.get('description').value
    coupon.couponType = this.addCouponFormGroup.get('discountType').value
    coupon.discount = this.addCouponFormGroup.get('discountValue').value
    coupon.createdAt = this.addCouponFormGroup.get('startedDate').value
    coupon.expiredAt = this.addCouponFormGroup.get('expiredDate').value

    if(this.couponService.insert(coupon)) {
      this.utilsService.updateToastState(new ToastState('add', 'coupon', 'success'))
      this.addCouponFormGroup.reset()
      this.router.navigate(['/admin/products/coupon'])
    }
  }

  submitEditCoupon() {
    if(this.editCouponFormGroup.invalid) {
      this.editCouponFormGroup.markAllAsTouched();
      this.utilsService.updateToastState(new ToastState('edit', 'coupon', 'danger'))
      return;
    }

    let coupon: Coupon = new Coupon();
    coupon.couponId = this.editCouponFormGroup.get('id').value
    coupon.code = this.editCouponFormGroup.get('code').value
    coupon.description = this.editCouponFormGroup.get('description').value
    coupon.couponType = this.editCouponFormGroup.get('discountType').value
    coupon.discount = this.editCouponFormGroup.get('discountValue').value
    coupon.createdAt = this.editCouponFormGroup.get('startedDate').value
    coupon.expiredAt = this.editCouponFormGroup.get('expiredDate').value

    if(this.couponService.insert(coupon)) {
      this.utilsService.updateToastState(new ToastState('edit', 'coupon', 'success'))
      this.couponService.updateHandleAndRowData('add');
      this.router.navigate(['/admin/products/coupon'])
    }
  }

  onDeleteConfirm(event): void {
    if (window.confirm("Are you sure you want to delete?")) {
      event.confirm.resolve();
    } else {
      event.confirm.reject();
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
}
