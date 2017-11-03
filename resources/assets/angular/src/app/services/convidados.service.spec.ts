import { TestBed, inject } from '@angular/core/testing';

import { ConvidadosService } from './convidados.service';

describe('ConvidadosService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ConvidadosService]
    });
  });

  it('should be created', inject([ConvidadosService], (service: ConvidadosService) => {
    expect(service).toBeTruthy();
  }));
});
