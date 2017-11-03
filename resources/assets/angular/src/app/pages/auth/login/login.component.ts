import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CanComponentDeactivateGuard} from "../../../guards/can-component-deactivate.guard";
import {Title} from "@angular/platform-browser";
import {Router} from "@angular/router";
import {AuthService} from "../../../services/auth.service";

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit, CanComponentDeactivateGuard {
    loginForm: FormGroup;
    submited: boolean = false;

    constructor(private formBuilder: FormBuilder, private title: Title, private router: Router, private authService: AuthService) {
        this.title.setTitle('Acessar');
    }

    ngOnInit() {
        this.loginForm = this.formBuilder.group({
            email: [null, Validators.required],
            password: [null, Validators.compose([Validators.required, Validators.minLength(6)])]
        });
    }

    canDeactivate() {
        if (this.loginForm.dirty && !this.submited) {
            return window.confirm('Deseja Realmente Sair?');
        }
        return true;
    }

    onSubmit() {
        this.authService
            .login(this.loginForm.value)
            .then((response) => {
                localStorage.setItem('API_TOKEN', response.token);
            })
            .catch()
    }
}
