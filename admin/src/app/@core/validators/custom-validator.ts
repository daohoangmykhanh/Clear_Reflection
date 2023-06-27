import { AbstractControl, FormControl, ValidationErrors } from "@angular/forms";

export class CustomValidator {
    static notBlank(control: FormControl): ValidationErrors {
        if (typeof control.value === 'string') {
            if (control.value != null && control.value.trim().length === 0) {
                return { 'notblank': true };
            }
        } else if (typeof control.value === 'number') {
            if (control.value === null || isNaN(control.value)) {
                return { 'notblank': true };
            }
        }

        return null;
    }

    static maxCouponValue(control: AbstractControl): ValidationErrors | null {
        const discountTypeControl = control.parent?.get('discountType');
        const discountValue = control.value;

        if (discountTypeControl?.value === 'Percent' && discountValue > 100) {
        return { max: true };
        }
        return null;
    }
}
