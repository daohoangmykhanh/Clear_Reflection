import { Injectable } from "@angular/core";

@Injectable({
    providedIn: 'root'
})
export class BaseURLService {
    private _baseURL: string = "http://127.0.0.1:8000"
    get baseURL(): string{
        return this._baseURL ;
    }
}