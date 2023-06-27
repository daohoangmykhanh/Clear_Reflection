import { Image } from "../image.model";
import { Cart } from "./cart.model";
import { Role } from "./role.model"
import { Wishlist } from "./wishlist.model";

export class Account {
    accountId: number
    username: string;
    password: string;   
    fullName: string;
    email: string;
    phoneNumber: string;
    role: Role;
    image: Image;
    address: string;
    createdAt: Date
    updatedAt: Date

    cart: Cart;
    wishlist: Wishlist[];
    order
}