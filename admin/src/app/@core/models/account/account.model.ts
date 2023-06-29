import { Image } from "../image.model";
import { Cart } from "../cart/cart.model";
import { Role } from "./role.model"
import { Wishlist } from "./wishlist.model";
import { Address } from "../address/address.model";
import { Order } from "../order/order.model";

export class Account {
    accountId: number
    password?: string;   
    fullName: string;
    email: string;
    phoneNumber: string;
    role?: Role;
    imageUrl: string;
    createdAt: Date
    updatedAt: Date
    address?: Address[]
    cart?: Cart;
    wishlist?: Wishlist[];
    orders?: Order[]
}