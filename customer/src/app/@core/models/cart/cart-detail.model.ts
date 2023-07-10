import { ProductVariant } from "../product/product-variant.model";
import { Product } from "../product/product.model";

export class CartDetail {
    cartDetailId: number;
    product?: Product;
    productVariant: ProductVariant;
    quantity: number;
    price: number;

    createdAt: Date;
    updatedAt: Date
}
