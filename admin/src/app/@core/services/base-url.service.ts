import { Injectable } from "@angular/core";

@Injectable({
    providedIn: 'root'
})
export class BaseURLService {
    private _baseURL: string = "http://localhost:8000/api"
    get baseURL(): string{
        return this._baseURL ;
    }
}