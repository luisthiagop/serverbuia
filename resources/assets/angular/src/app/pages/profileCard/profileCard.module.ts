import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ProfileCardComponent } from './profileCard.component';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [
    ProfileCardComponent
  ],
  exports: [
    ProfileCardComponent
  ]
})
export class ProfileCardModule { }
