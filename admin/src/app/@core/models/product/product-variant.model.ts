import { Image } from "../image.model";
import { ProductColor } from "./product-color.model";

export class ProductVariant {
    productVariantId: number;
    height: number;
    width: number;
    color: ProductColor;
    quantity: number;
    price: number;
    imageUrl?: string;
}