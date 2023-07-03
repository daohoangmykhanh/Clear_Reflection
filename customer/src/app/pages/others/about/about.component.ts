import { Component, OnInit, ChangeDetectionStrategy } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';

import { iconBoxes, counters } from './about-data';
import { TranslateService } from '@ngx-translate/core';

@Component({
	selector: 'pages-about-page',
	templateUrl: './about.component.html',
	styleUrls: ['./about.component.scss'],
	changeDetection: ChangeDetectionStrategy.OnPush
})

export class AboutPageComponent implements OnInit {

	iconBoxes = iconBoxes;
	counters = counters;
  currentLang: string;
	constructor(
    public sanitizer: DomSanitizer,
    private translateService: TranslateService
  ) {
    this.translateService.onLangChange.subscribe(event => {
      this.currentLang = event.lang
      console.log(this.currentLang);
    });
  }

	ngOnInit(): void {
	}
}
