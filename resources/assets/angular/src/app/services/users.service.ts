import {Injectable} from '@angular/core';
import {Headers, Http, Response} from "@angular/http";

@Injectable()
export class UsersService {

  base_url: string;
  token = status;
  headers: Headers;

  constructor(private http: Http) {
    this.base_url = 'localhost:8000';
    this.token = localStorage.getItem('API_TOKEN');
    this.headers = new Headers({
      'Accept': 'application/json',
      'Authorization': `Bearer ${this.token}`,
    });
  }

  show(id) {
    const url = `//${this.base_url}/api/users/${id}`;
    return this.http.get(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  update(form) {
    const url = `//${this.base_url}/api/users`;
    return this.http.put(url, form, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  destroy() {
    const url = `//${this.base_url}/api/users`;
    return this.http.delete(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  /*
  Verifica todas as festas públicas que o usuário foi
  Recebe o id do usuário
  Retorna todas as festas públicas
  */
  festas(id) {
    const url = `//${this.base_url}/api/users/festas/${id}`;
    return this.http.get(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  /*
  Próximas festas que o usuário foi convidado
  Retorna todas as festas
   */
  proxConvidado() {
    const url = `//${this.base_url}/api/users/convidado`;
    return this.http.get(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  /*
  Mostra todas as festas que o usuário confirmou presença e ainda não aconteceu
   */
  confirmado() {
    const url = `//${this.base_url}/api/users/confirmado`;
    return this.http.get(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  /*
  Mostra todas as festas que o usuário organiza e ainda não aconteceu
   */
  organiza() {
    const url = `//${this.base_url}/api/users/organiza`;
    return this.http.get(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }


  handleError(error: any): Promise<any> {
    if (error.status === 401) {
      return Promise.reject('Unauthorized');
    }
    if (error.status === 403) {
      return Promise.reject('Forbidden');
    }
    return Promise.reject(error);
  }
}
