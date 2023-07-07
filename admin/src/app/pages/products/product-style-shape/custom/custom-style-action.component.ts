import { style } from "@angular/animations";
import { Component, OnInit, Input, ViewChild, TemplateRef } from "@angular/core";
import { Router } from "@angular/router";
import { ViewCell } from "ng2-smart-table";
import { ProductCategoryService } from "../../../../@core/services/product/product-category.service";
import { NbWindowRef, NbWindowService } from "@nebular/theme";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { CustomValidator } from "../../../../@core/validators/custom-validator";
import { ProductStyle } from "../../../../@core/models/product/product-style.model";
import { ToastState, UtilsService } from "../../../../@core/services/utils.service";
import { ProductStyleService } from "../../../../@core/services/product/product-style.service";

@Component({
    selector: 'ngx-custom-action',
    template: `
        <div class="row no-gutters">
            <div class="col-lg-6  d-flex justify-content-center">
                <button nbButton status="warning" (click)="onEdit()">
                    <nb-icon icon="edit-2-outline"></nb-icon>
                </button>
            </div>
            <div class="col-lg-6  d-flex justify-content-center">
                <button nbButton status="danger" (click)="onDelete($event)">
                    <nb-icon icon="trash-outline"></nb-icon>
                </button>
            </div>
        </div>

        <ng-template #editStyle let-data>
            <div class="d-flex flex-column" [formGroup]="editStyleFormGroup">
                <input type="hidden" formControlName="productStyleId">
                <input type="text" nbInput fullWidth placeholder="Style Name" formControlName="styleName">
                <div class="alert alert-danger mt-1" 
                    *ngIf="editStyleFormGroup.get('styleName').invalid && (editStyleFormGroup.get('styleName').dirty || editStyleFormGroup.get('styleName').touched)">
                    <div *ngIf="editStyleFormGroup.get('styleName').errors['notblank']">
                        Style Name is required
                    </div>

                    <div *ngIf="editStyleFormGroup.get('styleName').errors['maxlength']">
                        Style Name must not exceed 100 characters
                    </div>
                </div>
                <button nbButton status="success" class="mt-3" (click)="ediStyle()">
                    SAVE
                </button>
            </div>
        </ng-template>
    `,
})

export class CustomStyleActionComponent implements ViewCell, OnInit {
    renderValue: string;

    @Input() value: string | number;
    @Input() rowData: any;

    windowRef: NbWindowRef;
    @ViewChild('editStyle') editStyle: TemplateRef<any>;
    editStyleFormGroup: FormGroup;


    constructor(
        private windowService: NbWindowService,
        private formBuilder: FormBuilder,
        private utilsService: UtilsService,
        private styleService: ProductStyleService,
        private router: Router
    ) {
        this.editStyleFormGroup = this.formBuilder.group({
            productStyleId: [],
            styleName: ['', [CustomValidator.notBlank, Validators.maxLength(100)]],
        })
    }

    ngOnInit(): void {
        if (this.rowData) {
            this.editStyleFormGroup.get('productStyleId').setValue(this.rowData.productStyleId);
            this.editStyleFormGroup.get('styleName').setValue(this.rowData.styleName);
        }
    }

    onDelete(event: any) {
        if (window.confirm('Are you sure you want to delete?')) {
            event.confirm.resolve();
        } else {
            event.confirm.reject();
        }
    }

    onEdit() {
        this.windowRef = this.windowService.open(
            this.editStyle, { title: 'Edit Style' },
        );
    }

    ediStyle() {
        if (this.editStyleFormGroup.invalid) {
            this.editStyleFormGroup.markAllAsTouched();
            this.utilsService.updateToastState(new ToastState('add', 'style', 'danger'))
            return;
        }
        let style: ProductStyle = this.editStyleFormGroup.value as ProductStyle
        console.log(style);
        if (this.styleService.insert(style)) {
            this.utilsService.updateToastState(new ToastState('add', 'style', 'success'))
            this.windowRef.close();
            this.router.navigate(['/admin/products/style-n-shape'])
        }
    }
}