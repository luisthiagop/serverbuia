import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {AuthGuard} from './guards/auth.guard';
import {DashboardComponent} from "./pages/dashboard/dashboard.component";
import {PerfilComponent} from "./pages/perfil/perfil.component";
import {InicioComponent} from "./pages/inicio/inicio.component";
import {CanComponentDeactivateGuard} from './guards/can-component-deactivate.guard';

const appRoutes: Routes = [
    {path: '', loadChildren: 'app/pages/auth/auth.module#AuthModule'},
    {path: 'eventos', loadChildren: 'app/pages/eventos/eventos.module#EventosModule'},
    {path: 'dashboard', component: DashboardComponent},
    {path: 'perfil', component: PerfilComponent},
    {path: 'inicio', component: InicioComponent}
];

@NgModule({
    imports: [RouterModule.forRoot(appRoutes, {enableTracing: false})],
    exports: [RouterModule],
    providers: [CanComponentDeactivateGuard, AuthGuard]
})

export class AppRoutingModule {
}
