import $ from 'jquery';

class VisShow{
  constructor(){
    this.showButton = $('#vis--show-solution');
    if(!this.showButton) return;
    this.readyButton = $('#vis-ready-button');
    this.chessboard = $('.question .rpbchessboard-chessboard')[0];
    this.questions = $('.question ol')[0];
    this.solutions = $('.question ol')[1];

    this.events();
  }

  events(){
    this.showButton.on('pointerdown', this.show.bind(this));
    this.readyButton.on('pointerdown', this.ready.bind(this));
  }

  show(){
    this.showButton[0].style.display="none";
    this.chessboard.style.display="block"
    this.questions.style.display="none";
    this.solutions.style.display="block";
  }

  ready(){
    this.readyButton[0].style.display="none";
    this.showButton[0].style.display="block";
    this.chessboard.style.display="none";
    this.questions.style.display="block";
  }
}

export default VisShow;
