import { Image } from "../image.model";
import { ProductCategory } from "./product-category.model";
import { ProductShape } from "./product-shape.model";
import { ProductStyle } from "./product-style.model";
import { ProductVariant } from "./product-variant.model";

export class Product {
    productId: number;
    productName: string;
    description: string;
    isHide: boolean;
    category: ProductCategory;
    shape: ProductShape;
    style: ProductStyle;
    createdAt: Date;
    updatedAt: Date;
    
    // optionals
    productVariants?: ProductVariant[]
    imageUrls?: string[]
    totalQuantity?: number
    quantitySold?: number
    totalLikes?: number
    rating?: number
    totalRating?: number
}

export class GetResponseProduct {
    product: Product;
    links: {
        linksabcxyz
    }
}