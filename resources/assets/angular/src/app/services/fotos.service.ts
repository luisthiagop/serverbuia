import {Injectable} from '@angular/core';
import {Headers, Http, Response} from "@angular/http";
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class FotosService {
  base_url: string;
  token = status;
  headers: Headers;

  constructor(private http: Http) {
    this.base_url = 'localhost:8000/api';
    this.token = localStorage.getItem('API_TOKEN');
    this.headers = new Headers({
      'Accept': 'application/json',
      'Authorization': `Bearer ${this.token}`,
    });
  }

  store(form) {
    const url = `//${this.base_url}/fotos`;
    // Falta upload da foto
    return this.http.post(url, form, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  //
  show(id) {
    const url = `//${this.base_url}/fotos/${id}`;
    return this.http.get(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  update(form, id) {
    const url = `//${this.base_url}/fotos/${id}`;
    // Falta upload da foto
    return this.http.put(url, form, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  destroy(id) {
    const url = `//${this.base_url}/fotos/${id}`;
    return this.http.delete(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  fotos(idfesta) {
    const url = `//${this.base_url}/fotos/${idfesta}`;
    return this.http.get(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  aprova(form, id) {
    const url = `//${this.base_url}/fotos/${id}`;
    return this.http.put(url, {headers: this.headers})
      .toPromise()
      .then((response: Response) => response.json())
      .catch(this.handleError);
  }

  handleError(error: any): Promise<any> {
    if (error.status === 400) {
      return Promise.reject(error.json());
    }
    if (error.status === 401) {
      return Promise.reject('Unauthorized');
    }
    if (error.status === 403) {
      return Promise.reject('Forbidden');
    }
    return Promise.reject(error);
  }

}
