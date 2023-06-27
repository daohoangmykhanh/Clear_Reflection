import { Coupon } from "../coupon.model";
import { OrderDetail } from "./order-detail.model";
import { OrderStatus } from "./order-status.model";

export class Order {
    orderId: number;
    orderTrackingNumber;
    coupon: Coupon;
    totalPrice: number;
    totalQuantity: number;
    orderStatus: OrderStatus
    billingAddress: string;
    shippingAddress: string;
    orderDetail: OrderDetail[];
    createdAt: Date
    updatedAt: Date
    
}