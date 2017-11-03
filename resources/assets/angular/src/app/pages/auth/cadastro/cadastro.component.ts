import {Component, OnInit} from '@angular/core';
import {AbstractControl, FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {CanComponentDeactivateGuard} from "../../../guards/can-component-deactivate.guard";
import {BsDatepickerConfig} from "ngx-bootstrap/datepicker";
import {defineLocale} from 'ngx-bootstrap/bs-moment';
import {ptBr} from 'ngx-bootstrap/locale';
import {Title} from "@angular/platform-browser";
import {AuthService} from "../../../services/auth.service";
import {Router} from "@angular/router";
defineLocale('pt-br', ptBr);

@Component({
    selector: 'app-cadastro',
    templateUrl: './cadastro.component.html',
    styleUrls: ['./cadastro.component.css']
})
export class CadastroComponent implements OnInit, CanComponentDeactivateGuard {
    signupForm: FormGroup;
    bsConfig: Partial<BsDatepickerConfig>;
    submited: boolean = false;

    constructor(private formBuilder: FormBuilder, private title: Title, private authService: AuthService, private router: Router) {
        this.title.setTitle('Cadastrar-se');
        this.bsConfig = Object.assign({}, {locale: 'pt-br', showWeekNumbers: false, dateInputFormat: 'DD/MM/YYYY'});
    }

    onSubmit() {
        this.authService
            .create(this.signupForm.value)
            .then((response) => {
                this.submited = true;
                this.router.navigate(['/login']);
            })
            .catch();
    }

    ngOnInit() {
        this.signupForm = this.formBuilder.group({
            email: [null, Validators.compose([Validators.required])],
            nome: [null, Validators.compose([Validators.required, Validators.minLength(3)])],
            data_nascimento: [null, Validators.compose([Validators.required])],
            password: [null, Validators.compose([Validators.required, Validators.minLength(6)])],
            password_confirmation: [null, Validators.compose([Validators.required, Validators.minLength(6)])]
        }, {validator: this.password_confirmed});
    }

    canDeactivate() {
        if (this.signupForm.dirty && !this.submited) {
            return window.confirm('Deseja Realmente Sair?');
        }
        return true;
    }

    password_confirmed(group: AbstractControl) {
        let password = group.get('password').value;
        let password_confirmation = group.get('password_confirmation').value;
        if (password !== password_confirmation) {
            group.get('password_confirmation').setErrors({MatchPassword: true})
        } else {
            return null
        }
    }
}