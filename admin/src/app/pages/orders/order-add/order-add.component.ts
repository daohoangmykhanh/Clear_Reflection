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
import { CustomValidator, isEmailNotExisting, isProductidNotExisting } from '../../../@core/validators/custom-validator';
import { Order } from '../../../@core/models/order/order.model';
import { ModelResponse } from '../../../@core/models/response/ModelResponse';

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
  chosenAccount: Account
  paymentMethods: PaymentMethod[]
  orderStatuses: OrderStatus[]
  provinces: Province[]
  district: District[]
  existingAddress: Address[]
  wards: Ward[]
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
    private utilsService: UtilsService
  ) {
      this.orderStatusService.findAll().subscribe(data => this.orderStatuses = data)
      this.paymentMethodService.findAll().subscribe(data => this.paymentMethods = data)
  }
  
  get products() { return this.addOrderFormGroup.controls["products"] as FormArray }
  settingFormGroup() {
    this.addOrderFormGroup = this.formBuilder.group({
      email: ['', CustomValidator.notBlank, isEmailNotExisting(this.accountService)],
      coupon: [],
      totalPrice: [, Validators.required],
      totalQuantity: [, Validators.required],
      orderStatus: ['', Validators.required],
      paymentMethod: ['', Validators.required],
      addressOption: ['', Validators.required],
      province: ['', Validators.required],
      district: ['', Validators.required],
      ward: ['', Validators.required],
      address: ['', CustomValidator.notBlank, Validators.maxLength(50)],
      products: this.formBuilder.array([])
    })
  }

  ngOnInit() {
    this.settingFormGroup()
    this.addProduct()
    this.accountCompleter()
    this.onAddressChange()
  }
  
  productCompleter$: Observable<Product[] | ModelResponse>
  productCompleter(productFormIndex: number) {
    this.productCompleter$ = this.products.at(productFormIndex).get('id').valueChanges.pipe(
      startWith(''),
      switchMap(enteredProductName => {
        if(this.products.at(productFormIndex).get('id').value == '' ||
          this.products.at(productFormIndex).get('id').value == null
        ) {
          return this.productService.findAll()
        }
        return this.productService.findByNameKeyword(enteredProductName)
      })
    );
  }

  accountCompleter$: Observable<Account[]>;
  accountCompleter() {
    this.accountCompleter$ = this.addOrderFormGroup.get('email').valueChanges.pipe(
      startWith(''),
      switchMap(enteredEmail => {
        if(this.addOrderFormGroup.get('email').value == '') {
          return this.accountService.findAll()
        }
        return this.accountService.findByEmailKeyword(enteredEmail)
      })
    );
  }


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
    this.accordions.first.toggle()
  }
  
  selectCustomer(account: Account) {
    this.chosenAccount = account;
    this.addOrderFormGroup.get('email').setValue(account.email)
    if(account.address == null || account.address.length == 0) {
      this.addressOptions[1].disabled = false
      this.addOrderFormGroup.get('addressOption').setValue('new')
    } else {
      this.addressOptions[0].disabled = true
      this.addressOptions[1].disabled = true

      this.existingAddress = account.address
    }
  }

  selectProduct(product: Product, productFormIndex: number) {
    this.products.controls[productFormIndex].get('id').setValue(product.productId)
  }

  onSubmit() {
    console.log(this.addOrderFormGroup.value);
    if(this.addOrderFormGroup.invalid) {
      this.addOrderFormGroup.markAllAsTouched();
      this.utilsService.updateToastState(new ToastState('add', 'order', 'danger'))
      return;
    }

    let order: Order = new Order();
  }
}
