import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {AuthComponent} from './auth.component';
import {RouterModule, Routes} from "@angular/router";
import {CadastroComponent} from "./cadastro/cadastro.component";
import {LoginComponent} from "./login/login.component";
import {CanComponentDeactivateGuard} from "../../guards/can-component-deactivate.guard";

const authRoutes: Routes = [{
    path: '', component: AuthComponent, children: [
        {path: '', component: CadastroComponent, canDeactivate: [CanComponentDeactivateGuard]},
        {path: 'login', component: LoginComponent, canDeactivate: [CanComponentDeactivateGuard]}
    ]
}];

@NgModule({
    imports: [RouterModule.forChild(authRoutes)],
    exports: [RouterModule]
})

export class AuthRoutingModule {
}
