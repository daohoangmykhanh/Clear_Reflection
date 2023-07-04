import { of, Observable } from 'rxjs';
import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { BaseURLService } from "../base-url.service";
import { OrderStatus } from '../../models/order/order-status.model';

@Injectable({
    providedIn: 'root'
})
export class OrderStatusService {
    constructor(
        private baseUrlService: BaseURLService,
        private httpClient: HttpClient
    ) { }


    findAll(): Observable<OrderStatus[]> {
        return of([
            {
                orderStatusId: 1,
                statusName: 'Handling',
                statusDescription: 'The order are handling'
            },
            {
                orderStatusId: 2,
                statusName: 'Delivering',
                statusDescription: 'The products of order are Delivering'
            },
            {
                orderStatusId: 3,
                statusName: 'Paid',
                statusDescription: 'The order are paid'
            },
            {
                orderStatusId: 4,
                statusName: 'Completed',
                statusDescription: 'The order are paid and Delivered'
            }
        ])
    }

    findById(id: number): Observable<OrderStatus> {
        let os: OrderStatus
        this.findAll().subscribe(
            data => {
                os = data.find(status => status.orderStatusId == id)
            }
        )
        return of(os)
    }
}