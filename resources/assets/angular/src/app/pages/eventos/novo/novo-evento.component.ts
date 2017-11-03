import {
    AfterViewInit, Component, ElementRef, EventEmitter, Input, OnDestroy, OnInit, Output,
    ViewChild
} from '@angular/core';
import {Title} from "@angular/platform-browser";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {EventoService} from "../../../services/evento.service";
import {CanComponentDeactivateGuard} from "../../../guards/can-component-deactivate.guard";
import {} from 'googlemaps';
import {BsDatepickerConfig} from "ngx-bootstrap/datepicker";
import {defineLocale} from 'ngx-bootstrap/bs-moment';
import {ptBr} from 'ngx-bootstrap/locale';
import {MapsAPILoader} from "@agm/core";
defineLocale('pt-br', ptBr);

@Component({
    selector: 'app-novo-evento',
    templateUrl: './novo-evento.component.html',
    styleUrls: ['./novo-evento.component.css']
})

export class NovoEventoComponent implements OnInit, AfterViewInit, OnDestroy, CanComponentDeactivateGuard {
    public novoEventoForm: FormGroup;
    public tipoEvento = [null, 'Publico', 'Fechado'];
    public lat: number = -14.2350040;
    public lng: number = -51.9252800;
    public zn: number = 3;
    @ViewChild('mapa') mapa: ElementRef;
    bsConfig: Partial<BsDatepickerConfig>;
    @Input() elementId: String;
    @Output() onEditorKeyup = new EventEmitter<any>();


    constructor(private title: Title, private formBuilder: FormBuilder, private eventoService: EventoService, private mapsAPILoader: MapsAPILoader) {
        this.title.setTitle('Novo Evento');
        this.bsConfig = Object.assign({}, {locale: 'pt-br', showWeekNumbers: false, dateInputFormat: 'DD/MM/YYYY'});
    }

    canDeactivate() {
        if (this.novoEventoForm.dirty) {
            return window.confirm('Descartar Alterações?');
        }
        return true;
    }

    ngOnInit() {
        this.novoEventoForm = this.formBuilder.group({
            titulo: [null, Validators.compose([Validators.required, Validators.minLength(3)])],
            data_evento: [null, Validators.compose([Validators.required])],
            hora_evento: [new Date(Date.now()), Validators.required],
            tipo_evento: [null, Validators.required],
            descricao: [""],
            endereco: this.formBuilder.group({
                nome_local: [null, Validators.required],
                cep: [null, Validators.compose([Validators.required, Validators.minLength(8)])],
                rua: [null, Validators.required],
                bairro: [null, Validators.required],
                localidade: [null, Validators.required],
                uf: [null, Validators.required],
                numero: [null, Validators.required],
            })
        });
    }

    onSubmit() {
        console.log(this.novoEventoForm.value);
    }

    buscaCEP(cep: string) {
        cep = cep.replace(/\D/g, '');
        if (cep.length !== 8) {
            return;
        }
        this.eventoService
            .buscaCep(cep)
            .then((endereco) => {
                this.patchForm(endereco);
                this.mapsAPILoader.load().then(() => {
                    let geocoder = new google.maps.Geocoder();
                    let g = geocoder.geocode({'address': cep}, (results, status) => {
                        if (status !== google.maps.GeocoderStatus.OK) {
                            return;
                        }
                        this.lat = results[0].geometry.location.lat();
                        this.lng = results[0].geometry.location.lng();
                        this.zn = 18;
                    });
                });
            })
            .catch();
    }

    patchForm(address) {
        this.novoEventoForm.patchValue({
            endereco: {
                rua: address.logradouro,
                bairro: address.bairro,
                localidade: address.localidade,
                uf: address.uf
            }
        })
    }

    editor;

    ngAfterViewInit() {
        tinymce.init({
            selector: 'textarea',
            language_url: '/assets/langs/pt_BR.js',
            resize: false,
            plugins: ['link', 'paste', 'table'],
            skin_url: '/assets/skins/lightgray',
            setup: editor => {
                this.editor = editor;
                editor.on('keyup', () => {
                    const content = editor.getContent();
                    this.onEditorKeyup.emit(content);
                    this.novoEventoForm.patchValue({
                        descricao: content
                    })
                });
            },
        });
    }

    ngOnDestroy() {
        tinymce.remove(this.editor);
    }
}
