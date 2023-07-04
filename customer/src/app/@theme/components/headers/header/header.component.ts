import { TranslateService } from '@ngx-translate/core';
import { Component, OnInit, Input } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

import { UtilsService } from 'src/app/@core/services/utils.service';
import { ModalService } from 'src/app/@core/services/modal.service';
import { WishlistService } from 'src/app/@core/services/wishlist.service';

@Component({
  selector: 'molla-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})

export class HeaderComponent implements OnInit {

  @Input() containerClass = "container";
  currentLang: string = 'ENG';
  wishCount = 0;

  constructor(
    public activeRoute: ActivatedRoute,
    public utilsService: UtilsService,
    public modalService: ModalService,
    public wishlistService: WishlistService,
    private translate: TranslateService
  ) {
  }

  ngOnInit(): void {
  }

  showLoginModal(event: Event): void {
    event.preventDefault();
    this.modalService.showLoginModal();
  }

  changeLang(lan: string) {
    this.translate.use(lan)
    if(lan == 'vi') {
      this.currentLang = 'VIE'
    } else if(lan == 'en-US'){
      this.currentLang = 'ENG'
    }
  }
}
