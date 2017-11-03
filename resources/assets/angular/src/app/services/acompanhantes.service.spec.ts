import { TestBed, inject } from '@angular/core/testing';

import { AcompanhantesService } from './acompanhantes.service';

describe('AcompanhantesService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [AcompanhantesService]
    });
  });

  it('should be created', inject([AcompanhantesService], (service: AcompanhantesService) => {
    expect(service).toBeTruthy();
  }));
});
