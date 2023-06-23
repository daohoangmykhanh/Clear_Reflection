import { AfterViewInit, Component, OnInit, QueryList, ViewChild, ViewChildren } from '@angular/core';
import { NbAccordionItemComponent } from '@nebular/theme';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

@Component({
  selector: 'ngx-product-add',
  templateUrl: './product-add.component.html',
  styleUrls: ['./product-add.component.scss']
})
export class ProductAddComponent implements OnInit, AfterViewInit{
  @ViewChild('carousel', { static: true }) carousel: any;
  @ViewChildren(NbAccordionItemComponent) accordions: QueryList<NbAccordionItemComponent>;
  
  public Editor = ClassicEditor;
  editorConfig: any = {
    placeholder: 'Description'
  };
  variants: any[] = [{}]
  editorContent;
  selectedCategory;
  selectedShape;
  selectedStyle;
  
  images: any[] = [
    {url: 'assets/images/camera1.jpg'},
    {url: 'assets/images/camera2.jpg'},
    {url: 'assets/images/camera3.jpg'},
    {url: 'assets/images/camera4.jpg'},
  ];
  activeSlideIndex = 0;
  basicColor: {value: string, label: string}[];
  chosenColorType: string;
  ngOnInit() {
    this.basicColor = [
      { value: 'This is value 1', label: 'Option 1' },
      { value: 'This is value 2', label: 'Option 2' },
    ];
  }
  
  ngAfterViewInit(): void {
    this.accordions.first.toggle()
  }

  prevSlide(carousel: any): void {
    this.activeSlideIndex = (this.activeSlideIndex - 1 + this.images.length) % this.images.length;
    carousel.cycleTo(this.activeSlideIndex);
  }

  nextSlide(carousel: any): void {
    this.activeSlideIndex = (this.activeSlideIndex + 1) % this.images.length;
    carousel.cycleTo(this.activeSlideIndex);
  }
  
  addVariant() {
    this.variants.push({});
  }
}
