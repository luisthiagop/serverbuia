import {NgModule} from '@angular/core';
import {RouterModule, Routes} from "@angular/router";
import {NovoEventoComponent} from "./novo/novo-evento.component";
import {EventosComponent} from "./eventos.component";
import {ExibirEventoComponent} from "./exibir/exibir-evento.component";
import {CanComponentDeactivateGuard} from "../../guards/can-component-deactivate.guard";

const eventosRoutes: Routes = [{
    path: '', component: EventosComponent, children: [
        {path: 'novo', component: NovoEventoComponent, canDeactivate: [CanComponentDeactivateGuard]},
        {path: ':id', component: ExibirEventoComponent}
    ]
}];

@NgModule({
    imports: [RouterModule.forChild(eventosRoutes)],
    exports: [RouterModule]
})

export class EventosRoutingModule {
}
