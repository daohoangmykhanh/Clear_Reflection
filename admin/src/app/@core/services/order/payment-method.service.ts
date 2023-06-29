import { of, Observable } from 'rxjs';
import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BaseURLService } from "../base-url.service";
import { OrderStatus } from '../../models/order/order-status.model';
import { PaymentMethod } from '../../models/order/payment-method.model';

@Injectable({
    providedIn: 'root'
})
export class PaymentMethodService {
    constructor(
        private baseUrlService: BaseURLService,
        private httpClient: HttpClient
    ) { }


    findAll(): Observable<PaymentMethod[]> {
        return of([
            {
                paymentMethodId: 1,
                paymentMethodName: 'Paypal',
            },
            {
                paymentMethodId: 2,
                paymentMethodName: 'Vnpay',
            },
        ])
    }

    findById(id: number): Observable<PaymentMethod> {
        let pm: PaymentMethod
        this.findAll().subscribe(
            data => {
                pm = data.find(p => p.paymentMethodId == id)
            }
        )
        return of(pm)
    }
}