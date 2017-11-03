import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {AuthComponent} from './auth.component';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {AuthRoutingModule} from "./auth.routing.module";
import {CadastroComponent} from "./cadastro/cadastro.component";
import {LoginComponent} from "./login/login.component";
import {Title} from "@angular/platform-browser";
import {CanComponentDeactivateGuard} from "../../guards/can-component-deactivate.guard";
import {BsDatepickerModule} from "ngx-bootstrap";
import {AuthService} from "../../services/auth.service";

@NgModule({
    imports: [CommonModule, FormsModule, ReactiveFormsModule, AuthRoutingModule, BsDatepickerModule],
    declarations: [CadastroComponent, LoginComponent, AuthComponent],
    providers: [AuthService, Title, CanComponentDeactivateGuard]
})
export class AuthModule {
    constructor() {
        console.log(navigator.appName);
        console.log(localStorage.getItem('API_TOKEN'));
    }
}
