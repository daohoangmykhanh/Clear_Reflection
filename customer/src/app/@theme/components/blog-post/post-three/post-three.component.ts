import { Component, OnInit, Input } from '@angular/core';

import { Post } from 'src/app/@core/models/post';

import { ModalService } from 'src/app/@core/services/modal.service';

import { sliderOpt } from 'src/app/@theme/data';
import { environment } from 'src/environments/environment';

@Component({
	selector: 'molla-post-three',
	templateUrl: './post-three.component.html',
	styleUrls: ['./post-three.component.scss']
})

export class PostThreeComponent implements OnInit {

	@Input() post: Post;
	@Input() adClass = '';

	sliderOption = { ...sliderOpt, loop: false, dots: false };
	SERVER_URL = environment.SERVER_URL;
	paddingTop = '100%';

	constructor(private modalService: ModalService) { }

	ngOnInit(): void {
		this.paddingTop = Math.floor((parseFloat(this.post.image[0].height.toString()) / parseFloat(this.post.image[0].width.toString()) * 1000)) / 10 + '%';
	}

	showModal(event: Event) {
		event.preventDefault();
		this.modalService.showVideoModal();
	}
}