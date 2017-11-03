import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {AppComponent} from './app.component';
import {AppRoutingModule} from "./app-routing.module";
import {BsDatepickerModule} from "ngx-bootstrap/datepicker";
import {TimepickerModule} from 'ngx-bootstrap';
import {EventoService} from "./services/evento.service";
import {HttpModule} from "@angular/http";
import {AgmCoreModule} from "@agm/core";
import {DashboardComponent} from "./pages/dashboard/dashboard.component";
import {PerfilComponent} from "./pages/perfil/perfil.component";
import {InicioComponent} from "./pages/inicio/inicio.component";
import {CanComponentDeactivateGuard} from "./guards/can-component-deactivate.guard";

import { HeaderModule } from "./pages/header/header.module";
import { FooterModule } from './pages/footer/footer.module';
import { CardModule } from './pages/card/card.module';
import { ProfileCardModule } from './pages/profileCard/profileCard.module';


@NgModule({
    declarations: [AppComponent, DashboardComponent, PerfilComponent, InicioComponent],
    imports: [HeaderModule, FooterModule, CardModule, ProfileCardModule, BrowserModule, AppRoutingModule, HttpModule, TimepickerModule.forRoot(), BsDatepickerModule.forRoot(), AgmCoreModule.forRoot({
        apiKey: "AIzaSyCS7t8haNC5tG30tCp7Q3ToZn7ZIo5NYIE",
        libraries: ['places'],
        language: 'pt-br',
        region: 'BR'
    })
  ],
    providers: [EventoService, CanComponentDeactivateGuard],
    bootstrap: [AppComponent]
})
export class AppModule {
}
