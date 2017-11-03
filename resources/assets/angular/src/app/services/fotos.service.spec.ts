import { TestBed, inject } from '@angular/core/testing';

import { FotosService } from './fotos.service';

describe('FotosService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [FotosService]
    });
  });

  it('should be created', inject([FotosService], (service: FotosService) => {
    expect(service).toBeTruthy();
  }));
});
