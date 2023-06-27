import { Product } from "../product/product.model";

export class OrderDetail {
    orderDetailID: number;
    product: Product;
    quantity: number;
    price: number;
}