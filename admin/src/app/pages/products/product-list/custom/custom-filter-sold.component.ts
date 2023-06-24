import { Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { FormControl } from '@angular/forms';
import { Router } from '@angular/router';
import { DefaultFilter } from 'ng2-smart-table';
import { debounceTime, distinctUntilChanged } from 'rxjs/operators';

@Component({
    template: `
        <select name="" id="" >
            <option value="">1</option>
            <option value="">2</option>
            <option value="">3</option>
            <option value="">4</option>
            <option value="">5</option>
        </select>
    `,
})
export class CustomFilterSoldComponent extends DefaultFilter implements OnInit, OnChanges {
    minControl = new FormControl();
    maxControl = new FormControl();

    constructor(private router: Router) {
        super();
    }

    ngOnInit() {
        this.minControl.valueChanges
            .pipe(
                distinctUntilChanged(),
                debounceTime(this.delay),
            )
            .subscribe((value: number) => {
                this.query = value !== null ? this.minControl.value.toString() : '';
                this.setFilter();
            });

        this.maxControl.valueChanges
        .pipe(
            distinctUntilChanged(),
            debounceTime(this.delay),
        )
        .subscribe((value: number) => {
            this.query = value !== null ? this.maxControl.value.toString() : '';
            this.setFilter();
        });
        
    }

    ngOnChanges(changes: SimpleChanges) {
        if (changes.query) {
            this.query = changes.query.currentValue;
            this.minControl.setValue(this.query);
            this.maxControl.setValue(this.query);
        }
        
    }
}