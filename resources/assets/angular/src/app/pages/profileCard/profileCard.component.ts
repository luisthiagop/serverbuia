import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-profileCard',
  templateUrl: './profileCard.component.html',
  styleUrls: ['./profileCard.component.css']
})
export class ProfileCardComponent implements OnInit {
  @Input() img: string;
  @Input() titulo: string;
  @Input() descricao: string;
  @Input() data: string;

  constructor() { }

  ngOnInit() {
  }

}
