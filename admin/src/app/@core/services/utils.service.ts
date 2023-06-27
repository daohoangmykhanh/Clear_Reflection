import { Injectable } from '@angular/core';
import { Observable, of, BehaviorSubject } from 'rxjs';

export class ToastState {
    constructor(
        public behavior: string,
        public model: string,
        public status: string,
    ) {}
    
}

@Injectable({
    providedIn: 'root'
})
export class UtilsService {
    private toastStateSubject: BehaviorSubject<ToastState> = new BehaviorSubject<ToastState>(null);
    toastState$: Observable<ToastState> = this.toastStateSubject.asObservable();

    updateToastState(toastState: ToastState): void {
        this.toastStateSubject.next(toastState);
    }

    constructor(
    ) { }
}
