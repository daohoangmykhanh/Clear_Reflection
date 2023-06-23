import { AfterViewInit, Component, OnInit, QueryList, ViewChild, ViewChildren } from '@angular/core';
import { FormControl } from '@angular/forms';
import { NbAccordionItemComponent } from '@nebular/theme';
import { CompleterCmp, CompleterData, CompleterService } from 'ng2-completer';
import { Observable, of } from 'rxjs';
import { map, startWith } from 'rxjs/operators';

@Component({
  selector: 'ngx-order-add',
  templateUrl: './order-add.component.html',
  styleUrls: ['./order-add.component.scss']
})
export class OrderAddComponent implements OnInit, AfterViewInit {
  @ViewChild(CompleterCmp, { static: false }) completer: CompleterCmp;
  @ViewChildren(NbAccordionItemComponent) accordions: QueryList<NbAccordionItemComponent>;
  variants: any[] = [{}]
  applyCoupon: boolean = false;
  searchStr: string;
  selectedOrderStatus;
  dataService: CompleterData;
  searchData = [
    { color: 'red', value: '#f00' },
    { color: 'green', value: '#0f0' },
    { color: 'blue', value: '#00f' },
    { color: 'cyan', value: '#0ff' },
    { color: 'magenta', value: '#f0f' },
    { color: 'yellow', value: '#ff0' },
    { color: 'black', value: '#000' }
  ];
    
  basicColor: {value: string, label: string}[];
  chosenColorType: string;

  constructor(
    private completerService: CompleterService,
  ) {
    this.dataService = completerService.local(this.searchData, 'color', 'color');
  }

  ngOnInit() {
    this.basicColor = [
      { value: 'This is value 1', label: 'Option 1' },
      { value: 'This is value 2', label: 'Option 2' },
    ];


    this.options = ['Option 1', 'Option 2', 'Option 3'];
    this.filteredOptions$ = of(this.options);

    this.inputFormControl = new FormControl();

    this.filteredOptions$ = this.inputFormControl.valueChanges
      .pipe(
        startWith(''),
        map(filterString => this.filter(filterString)),
      );
  }
  
  ngAfterViewInit(): void {
    this.accordions.first.toggle()
    const completerInput: HTMLInputElement = this.completer.ctrInput.nativeElement
    completerInput.setAttribute('placeholder', 'Customer Username')
    
    const a = this.completer
  }
  
  addVariant() {
    this.variants.push({});
  }

  options: string[];
  filteredOptions$: Observable<string[]>;
  inputFormControl: FormControl;

  private filter(value: string): string[] {
    const filterValue = value.toLowerCase();
    return this.options.filter(optionValue => optionValue.toLowerCase().includes(filterValue));
  }

  viewHandle(value: string) {
    return value.toUpperCase();
  }

  
}
