import { TranslateService } from '@ngx-translate/core';
import { Component, OnInit, Input } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { UtilsService } from 'src/app/@core/services/utils.service';
import { ModalService } from 'src/app/@core/services/modal.service';
import { WishlistService } from 'src/app/@core/services/wishlist.service';
import { AuthService } from 'src/app/@core/services/account/auth.service';
import { takeUntil } from 'rxjs/operators'
import { Subject } from 'rxjs'
@Component({
  selector: 'molla-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})

export class HeaderComponent implements OnInit {

  @Input() containerClass = "container";
  currentLang: string = 'ENG';
  wishCount = 0;
  isLoggedIn: boolean;

  constructor(
    public activeRoute: ActivatedRoute,
    public utilsService: UtilsService,
    public modalService: ModalService,
    public wishlistService: WishlistService,
    private translate: TranslateService,
    private authService: AuthService,
    private router: Router
  ) {
  }
  private unsubscribe = new Subject<void>();

  ngOnInit(): void {
    this.authService.authChange$
      .pipe(takeUntil(this.unsubscribe))
      .subscribe(() => {
        this.loadHeader();
      });
    this.loadHeader()
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

  logout() {
    this.authService.logout().subscribe(
      data => {
        if(data.result) {
          localStorage.removeItem("token")
          this.authService.authChange()
          this.router.navigate(['/'])
        }
      }
    )
  }

  loadHeader() {
    if(this.authService.isLoggedIn()) {
      this.isLoggedIn = true;
    } else {
      this.isLoggedIn = false
    }
  }
}
