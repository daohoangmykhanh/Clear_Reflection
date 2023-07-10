import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/@core/services/account/auth.service';

@Component({
  selector: 'molla-login-modal',
  templateUrl: './login-modal.component.html',
  styleUrls: ['./login-modal.component.scss']
})

export class LoginModalComponent implements OnInit {

  loggedIn: any;
  loginFormGroup: FormGroup
  registerFormGroup: FormGroup
  errorLoginMessage: string;
  registerLoginMessage: string;

  constructor(
    private router: Router,
    private formBuilder: FormBuilder,
    private authService: AuthService,
  ) {
    this.loginFormGroup = this.formBuilder.group({
      email: ['', [Validators.required]],
      password: ['', [Validators.required]]
    })

    this.registerFormGroup = this.formBuilder.group({
      email: ['', [Validators.required]],
      password: ['', [Validators.required]],
      fullName: ['', [Validators.required]],
      phoneNumber: ['', [Validators.required]]
    })
  }

  ngOnInit(): void {
  }

  login() {
    if (this.loginFormGroup.invalid) {
      this.loginFormGroup.markAllAsTouched();
      return;
    }
    this.authService.login(this.loginFormGroup.get('email').value, this.loginFormGroup.get('password').value)
      .subscribe(data => {
        console.log(data);

        if ("result" in data) {
          this.errorLoginMessage = 'Invalid email or password'

        } else {
          this.saveToken(data.token)
          this.closeModal()
          this.authService.authChange()
          this.router.navigate(['/'])
        }
      })
  }

  register() {
    if (this.registerFormGroup.invalid) {
      this.registerFormGroup.markAllAsTouched();
      return;
    }
    this.authService
      .register(
        this.registerFormGroup.get('email').value,
        this.registerFormGroup.get('password').value,
        this.registerFormGroup.get('fullName').value,
        this.registerFormGroup.get('phoneNumber').value,
      )
      .subscribe(
        data => {
          console.log(data);
          if (data.result) {
            this.authService.authChange()
            this.registerLoginMessage = 'Registered Successfully! Please login'
            this.registerFormGroup.reset()
          }
        },
        error => console.log(error)
      )
  }

  saveToken(token: string) {
    localStorage.setItem('token', token)
  }

  closeModal() {
    let modal = document.querySelector('.login-modal') as HTMLElement;
    if (modal)
      modal.click();
  }

}
