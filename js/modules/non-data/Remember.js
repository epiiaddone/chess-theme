import $ from 'jquery';

class Remember{
  constructor(){
    if(!document.getElementById('remember-page')) return;
    this.waitForScrollArea();
  }

  waitForScrollArea(){
    this.scrollArea = document.getElementsByClassName('rpbui-chessgame-scrollArea')[0];
    if(!this.scrollArea){
      let _this = this;
       setTimeout(function(){
         //console.log("waiting for scroll area");
         _this.waitForScrollArea();
       },100);
       return;
     }
     this.waitForMoveGroup();
  }

  waitForMoveGroup(){
    this.moveGroup = document.getElementsByClassName('rpbui-chessgame-moveGroup')[0];
    if(!this.moveGroup){
      let _this = this;
       setTimeout(function(){
         //console.log("waiting for move group");
         _this.waitForMoveGroup();
       },100);
       return;
     }
    this.waitForNextButton();
  }

  waitForNextButton(){
    this.nextButton = document.getElementsByClassName('rpbui-chessgame-navigationButtonNext')[0];
    if(!this.nextButton){
      let _this = this;
       setTimeout(function(){
         //console.log("waiting for next button");
         _this.waitForNextButton();
       },100);
       return;
     }
     this.waitForRotateButton();
  }

  waitForRotateButton(){
    this.rotateButton = document.getElementsByClassName('rpbui-chessgame-navigationButtonFlip')[0];
    if(!this.rotateButton){
      let _this = this;
       setTimeout(function(){
         //console.log("waiting for rotate button");
         _this.waitForRotateButton();
       },100);
       return;
     }
      this.constructorTwo();

  }



  constructorTwo(){
    this.totalMoveCount = 20;
    this.startButton = document.getElementById('startButton');
    this.whatNext = document.getElementById('whatNext');
    this.showNextButton = document.getElementById('showNextButton');
    this.correctFalse = document.getElementById('correctFalse');
    this.correctButton = document.getElementById('correctButton');
    this.falseButton = document.getElementById('falseButton');
    this.endAllCorrect = document.getElementById('endAllCorrect');
    this.endNotAllCorrect = document.getElementById('endNotAllCorrect');
    this.endNumberMoves = document.getElementById('endNumberMoves');
    this.skipToday = document.getElementById('remember--skip');
    this.nextCount = 0;
    this.movesReviewed = 0;

    this.setUpPage();
    this.events();
  }

  setUpPage(){
    this.rotateButton.parentNode.removeChild(this.rotateButton);
    this.scrollArea.style.display = 'none';
  }

  events(){
    this.nextButton.addEventListener('pointerdown', this.nextClicked.bind(this));
    this.startButton.addEventListener('pointerdown', this.startReview.bind(this));
    this.showNextButton.addEventListener('pointerdown', this.showClicked.bind(this));
    this.correctButton.addEventListener('pointerdown', this.correctClicked.bind(this));
    this.falseButton.addEventListener('pointerdown', this.falseClicked.bind(this));
    this.skipToday.addEventListener('pointerdown', this.skipClicked.bind(this));
  }

  skipClicked(){
    let user_uuid = document.getElementById('user_uuid').innerHTML;
    let remember_level = document.getElementById('remember_level').innerHTML;

    $.ajax({
      /*
      beforeSend:(xhr)=>{
        xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
      },
      */
      url:chessAppData.root_url + '/wp-json/user/v1/skipUserRemember',
      type:'POST',
      data:{
        'user_uuid': user_uuid,//cant get it from the php for some reason
        'remember_level':remember_level
      },
      success:(response)=>{//this is never reached regardless of succes or failure
        console.log(response);
      // location.reload(true);
      },
      error:(response)=>{
        console.log(response);
      //  location.reload(true);
      }
    });
  }

  nextClicked(){
    if(++this.nextCount==this.totalMoveCount + 1){
      this.nextButton.style.display='none';
      this.startButton.style.display='block';
    }
  }

  startReview(){
    this.startButton.style.display='none';
    this.whatNext.style.display='block';
    this.scrollArea.style.display='block';
  }

  showClicked(){
    this.whatNext.style.display = 'none';
    this.correctFalse.style.display = 'block';
    this.moveGroup.children[this.movesReviewed].style.display='inline-block';
    this.simulate(this.moveGroup.children[this.movesReviewed], 'click');
    this.movesReviewed++;
  }

  correctClicked(){
    this.correctFalse.style.display='none';
    if(this.getLevelMoveCount(this.level)==this.movesReviewed) {
      this.rememberEnd(true);
      return;
    }
    this.whatNext.style.display='block';
  }

  falseClicked(){
    this.rememberEnd(false);
  }

  rememberEnd(allCorrect){
    this.whatNext.style.display = 'none';
    this.correctFalse.style.display='none';
    if(allCorrect){
      this.endAllCorrect.style.display='block';
    }else{
      this.endNotAllCorrect.style.display = 'block';
      this.endNumberMoves.innerHTML = this.movesReviewed/2;
    }

    let user_uuid = document.getElementById('user_uuid').innerHTML;
    let movesCorrect = this.movesReviewed/2;
    let remember_level = document.getElementById('remember_level').innerHTML;

    document.getElementById('loading-display').style.display='block';
      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/updateUserRemember',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'remember_level':remember_level,
          'moves_correct':movesCorrect
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        // location.reload(true);
        },
        error:(response)=>{
          console.log(response);
        //  location.reload(true);
        }
      });
  }

  getLevelMoveCount(level){
    let moveCount = 0;
    switch(level){
      case '11': moveCount = 10; break;
      case '12': moveCount = 15; break;
      case '13': moveCount = 20; break;
      case '14': moveCount = 25; break;
      case '15': moveCount = 30; break;
      case '16': moveCount = 40; break;
    }
    return moveCount * 2;
  }

  simulate(element, eventName){

    var eventMatchers = {
        'HTMLEvents': /^(?:load|unload|abort|error|select|change|submit|reset|focus|blur|resize|scroll)$/,
        'MouseEvents': /^(?:click|dblclick|mouse(?:down|up|over|move|out))$/
    }
     var defaultOptions = {
        pointerX: 0,
        pointerY: 0,
        button: 0,
        ctrlKey: false,
        altKey: false,
        shiftKey: false,
        metaKey: false,
        bubbles: true,
        cancelable: true
    }
    var options = this.extend(defaultOptions, arguments[2] || {});
    var oEvent, eventType = null;

    for (var name in eventMatchers)
    {
        if (eventMatchers[name].test(eventName)) { eventType = name; break; }
    }

    if (!eventType)
        throw new SyntaxError('Only HTMLEvents and MouseEvents interfaces are supported');

    if (document.createEvent)
    {
        oEvent = document.createEvent(eventType);
        if (eventType == 'HTMLEvents')
        {
            oEvent.initEvent(eventName, options.bubbles, options.cancelable);
        }
        else
        {
            oEvent.initMouseEvent(eventName, options.bubbles, options.cancelable, document.defaultView,
            options.button, options.pointerX, options.pointerY, options.pointerX, options.pointerY,
            options.ctrlKey, options.altKey, options.shiftKey, options.metaKey, options.button, element);
        }
        element.dispatchEvent(oEvent);
    }
    else
    {
        options.clientX = options.pointerX;
        options.clientY = options.pointerY;
        var evt = document.createEventObject();
        oEvent = this.extend(evt, options);
        element.fireEvent('on' + eventName, oEvent);
    }
    return element;
}

extend(destination, source) {
    for (var property in source)
      destination[property] = source[property];
    return destination;
}

}



export default Remember;
