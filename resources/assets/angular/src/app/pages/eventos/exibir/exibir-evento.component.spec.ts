import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {ExibirEventoComponent} from './exibir-evento.component';

describe('EventoComponent', () => {
    let component: ExibirEventoComponent;
    let fixture: ComponentFixture<ExibirEventoComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            declarations: [ExibirEventoComponent]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(ExibirEventoComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should be created', () => {
        expect(component).toBeTruthy();
    });
});
