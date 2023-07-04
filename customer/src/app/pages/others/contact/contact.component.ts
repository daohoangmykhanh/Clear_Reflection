import { Component, OnInit, ChangeDetectionStrategy } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { of } from 'rxjs/internal/observable/of';
import { map, catchError } from 'rxjs/operators';

@Component({
	selector: 'pages-contact',
	templateUrl: './contact.component.html',
	styleUrls: ['./contact.component.scss'],
	changeDetection: ChangeDetectionStrategy.OnPush
})

export class ContactPageComponent implements OnInit {

	constructor(httpClient: HttpClient) {
	}

	ngOnInit(): void {
	}
}
