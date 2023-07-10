import { Account } from "../account/account.model";
import { CartDetail } from "./cart-detail.model";

export class Cart {
    cartId: number;
    cartDetails?: CartDetail[]
    account?: Account
    createdAt: Date;
    updatedAt: Date
}
