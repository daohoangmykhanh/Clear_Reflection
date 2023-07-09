import { ToastState, UtilsService } from './../../../@core/services/utils.service';
import { ProductService } from './../../../@core/services/product/product.service';
import { PaymentMethodService } from './../../../@core/services/order/payment-method.service';
import { AfterViewInit, Component, OnInit, QueryList, ViewChild, ViewChildren } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { NbAccordionItemComponent } from '@nebular/theme';
import { CompleterCmp, CompleterData, CompleterService } from 'ng2-completer';
import { Observable, of, } from 'rxjs';
import { switchMap } from 'rxjs/operators';
import { map, startWith } from 'rxjs/operators';
import { OrderService } from '../../../@core/services/order/order.service';
import { OrderStatusService } from '../../../@core/services/order/order-status.service';
import { PaymentMethod } from '../../../@core/models/order/payment-method.model';
import { OrderStatus } from '../../../@core/models/order/order-status.model';
import { Account } from '../../../@core/models/account/account.model';
import { AccountService } from '../../../@core/services/account/account.service';
import { Ward } from '../../../@core/models/address/wards.model';
import { Province } from '../../../@core/models/address/provinces.model';
import { District } from '../../../@core/models/address/districts.model';
import { Address } from '../../../@core/models/address/address.model';
import { Product } from '../../../@core/models/product/product.model';
import { CustomValidator, isCouponExisting, isEmailNotExisting, isProductidNotExisting } from '../../../@core/validators/custom-validator';
import { Order } from '../../../@core/models/order/order.model';
import { ModelResponse } from '../../../@core/models/response/ModelResponse';
import { AddressService } from '../../../@core/services/account/address.service';
import { ProductCouponService } from '../../../@core/services/product/product-coupon.service';

@Component({
  selector: 'ngx-order-add',
  templateUrl: './order-add.component.html',
  styleUrls: ['./order-add.component.scss']
})
export class OrderAddComponent implements OnInit, AfterViewInit {
  @ViewChild(CompleterCmp, { static: false }) completer: CompleterCmp;
  @ViewChildren(NbAccordionItemComponent) accordions: QueryList<NbAccordionItemComponent>;
  
  addOrderFormGroup: FormGroup
  // basic information
  chosenAccount: Account;
  accountDetail: Account;

  paymentMethods: PaymentMethod[]
  orderStatuses: OrderStatus[]
  provinces: Province[]
  districts: District[]
  wards: Ward[]
  existingAddress: Address[]

  addressOptions = [
    { value: 'existing', label: 'Use Existing Address', disabled: true },
    { value: 'new', label: 'New Address', disabled: true },
  ];
  applyCoupon: boolean = false;

  // for order's products

  constructor(
    private orderService: OrderService,
    private orderStatusService: OrderStatusService,
    private paymentMethodService: PaymentMethodService,
    private accountService: AccountService,
    private formBuilder: FormBuilder,
    private productService: ProductService,
    public utilsService: UtilsService,
    private addressService: AddressService,
    private couponService: ProductCouponService
  ) {
      this.orderStatusService.findAll().subscribe(data => this.orderStatuses = data)
      this.paymentMethodService.findAll().subscribe(data => this.paymentMethods = data)
  }
  

  settingFormGroup() {
    this.addOrderFormGroup = this.formBuilder.group({
      email: ['', CustomValidator.notBlank, isEmailNotExisting(this.accountService)],
      coupon: [''],
      totalPrice: [, Validators.required],
      totalQuantity: [, Validators.required],
      orderStatus: ['', Validators.required],
      paymentMethod: ['', Validators.required],
      addressOption: ['', Validators.required],
      province: ['', Validators.required],
      district: ['', Validators.required],
      ward: ['', Validators.required],
      address: ['', Validators.required, Validators.maxLength(50)],
      products: this.formBuilder.array([])
    })

    this.checkCouponExists()
  }

  ngOnInit() {
    this.settingFormGroup()
    this.addProduct()
    this.accountCompleter()
    this.onAddressChange()
  }
  
  accountCompleter$: Observable<Account[]>;
  accountCompleter() {
    this.accountCompleter$ = this.addOrderFormGroup.get('email').valueChanges.pipe(
      startWith(''),
      switchMap(enteredEmail => {
        if(this.addOrderFormGroup.get('email').value == '') {
          return this.accountService.findByEmailKeyword('')
        }
        return this.accountService.findByEmailKeyword(enteredEmail)
      })
    );
  }

  onAddressChange() {
    this.addOrderFormGroup.get('province').valueChanges.subscribe(data => {
      this.addOrderFormGroup.patchValue({
        district: '',
        wards: '',
        address: ''
      });
    });
    this.addOrderFormGroup.get('district').valueChanges.subscribe(data => {
      this.addOrderFormGroup.patchValue({
        wards: '',
        address: ''
      });
    });
  }
  
  ngAfterViewInit(): void {
    // this.accordions.first.toggle()
    1
  }
  
  selectCustomer(account: Account) {
    this.chosenAccount = account;
    this.accountService.findById(this.chosenAccount.accountId).subscribe(
      data => {
        this.accountDetail = data
        this.setUpAccountAddress()
      }
    )
  }

  setUpAccountAddress() {
    this.addOrderFormGroup.get('email').setValue(this.chosenAccount.email)
    
    if(this.accountDetail.address == undefined) {
      this.addressOptions[1].disabled = false
      this.addOrderFormGroup.get('addressOption').setValue('new')
      this.loadProvinces()
    } else {
      this.addressOptions[0].disabled = true
      this.addressOptions[1].disabled = true

      this.existingAddress = this.chosenAccount.address
    }
  }

  selectProduct(product: Product, productFormIndex: number) {
    this.products.controls[productFormIndex].get('id').setValue(product.productId)
  }

  onSubmit() {
    if(this.addOrderFormGroup.invalid) {
      this.addOrderFormGroup.markAllAsTouched();
      this.utilsService.updateToastState(new ToastState('add', 'order', 'danger'))
      return;
    }

    let order: any = this.mapFormValue()
    console.log(order)

  }

  mapFormValue(): any {
    let order:any  = new Order()
    order.customerEmail = this.addOrderFormGroup.get('email').value
    if(this.applyCoupon) {
      this.couponService.findIdByCode(this.addOrderFormGroup.get('coupon').value)
        .subscribe(data => order.couponId = data)
    }
    order.roadName = this.addOrderFormGroup.get('address').value
    order.ward = this.addOrderFormGroup.get('ward').value['code']
    order.district = this.addOrderFormGroup.get('district').value['code']
    order.province = this.addOrderFormGroup.get('province').value['code']
    order.orderStatusId = this.addOrderFormGroup.get('orderStatus').value['orderStatusId']
    order.paymentMethodId = this.addOrderFormGroup.get('paymentMethod').value['paymentMethodId']
    return order;
  }

  loadProvinces() {
    this.addressService.findAllProvinces().subscribe(
      data => {
        this.provinces = data.provinces
        this.addOrderFormGroup.get('district').setValue({})
        this.addOrderFormGroup.get('ward').setValue({})
      }
    )
  }

  loadDistricts(event: any) {
    const selectedProvince: Province = this.addOrderFormGroup.get('province').value
    this.addressService.findAllDistrictByProvince(selectedProvince.code).subscribe(
      data => {
        this.districts = data.districts
      }
    );
  }

  loadWards(event: any) {
    const selectedDistrict: District = this.addOrderFormGroup.get('district').value
    this.addressService.findAllWardByDistrict(selectedDistrict.code).subscribe(
      data => {
        this.wards = data.wards
        this.addOrderFormGroup.get('ward').setValue({})
      }
    );
  }

  checkCouponExists() {
    this.addOrderFormGroup.get('coupon').valueChanges.subscribe(
      () => {
        const couponValue = this.addOrderFormGroup.get('coupon').value
        console.log(couponValue);
        if(this.applyCoupon && couponValue == '') {
          this.addOrderFormGroup.get('coupon').setErrors({couponNotExists : true})
          return;
        }
        this.couponService.isCouponExists(couponValue).subscribe(
          result => {
            if(!result) {
              this.addOrderFormGroup.get('coupon').setErrors({couponNotExists : true})
            }
          }
        )
      }
    )
  }


  productCompleter$: Observable<Product[] | ModelResponse>
  productCompleter(productFormIndex: number) {
    this.productCompleter$ = this.products.at(productFormIndex).get('id').valueChanges.pipe(
      startWith(''),
      switchMap(enteredProductName => {
        if(this.products.at(productFormIndex).get('id').value == '') {
          return this.productService.findByNameKeyword('')
        }
        return this.productService.findByNameKeyword(enteredProductName)
      })
    );
  }

  get products() { return this.addOrderFormGroup.controls["products"] as FormArray }

  addProduct(): void {
    const productForm = this.formBuilder.group({
      id: [,  CustomValidator.notBlank, isProductidNotExisting(this.productService)],
      size: [, [Validators.required]] ,
      price: [{value: null, disabled: true}],
      quantity: [, [Validators.required, Validators.min(1), Validators.max(100000)]],
      color: [, [Validators.required]],
    })
    this.products.push(productForm)
    this.productCompleter(this.products.controls.length - 1)
  }
  removeProduct(productFormIndex: number): void { this.products.removeAt(productFormIndex) }
}
