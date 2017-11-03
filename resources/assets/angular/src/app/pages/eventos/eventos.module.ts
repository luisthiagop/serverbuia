import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {EventosRoutingModule} from "./eventos.routing.module";
import {EventosComponent} from "./eventos.component";
import {NovoEventoComponent} from "./novo/novo-evento.component";
import {ExibirEventoComponent} from "./exibir/exibir-evento.component";
import {Title} from "@angular/platform-browser";
import {CanComponentDeactivateGuard} from "../../guards/can-component-deactivate.guard";
import {BsDatepickerModule} from "ngx-bootstrap/datepicker";
import {AgmCoreModule} from "@agm/core";
import {TimepickerModule} from "ngx-bootstrap";

@NgModule({
    imports: [CommonModule, FormsModule, ReactiveFormsModule, EventosRoutingModule, TimepickerModule, BsDatepickerModule, AgmCoreModule],
    declarations: [EventosComponent, NovoEventoComponent, ExibirEventoComponent],
    providers: [Title, CanComponentDeactivateGuard]
})
export class EventosModule {
}
