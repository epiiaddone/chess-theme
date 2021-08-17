import $ from 'jquery';

class ShowSolution{
  constructor(){
    this.showButton = $('#question--show-solution');
    if(!this.showButton) return;
    this.ansButtons = $('#question--ans--buttons');
    this.lessonLink = $('#question-lesson-link');
    this.events();
  }

  events(){
    this.showButton.on('pointerdown', this.show.bind(this));
  }

  show(){
    this.showButton[0].style.display="none";
    $('.question .rpbui-chessgame')[0].style.display="block";
    this.ansButtons[0].style.display="flex";
    this.lessonLink[0].style.display="block";
  }
}

export default ShowSolution;
