import $ from 'jquery';

class UserQuestionReviewAjax{

    constructor(){
      if(!document.getElementById('question-review-identifier')) return;
      this.hardBtn = document.getElementById("hardButton");
      this.okayBtn = document.getElementById("okayButton");
      this.easyBtn = document.getElementById("easyButton");
      this.events();
    }

    events(){
      let _this = this;
      this.hardBtn.addEventListener("pointerdown", function(event){_this.sendData('hard')});
      this.okayBtn.addEventListener("pointerdown", function(event){_this.sendData('okay')});
      this.easyBtn.addEventListener("pointerdown", function(event){_this.sendData('easy')});
    }

    sendData(button_hit){

    let question_id = document.getElementById('question_id').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/updateUserQuestion',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'question_id':question_id,
          'button_hit':button_hit,
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
         document.location.reload();
        },
        error:(response)=>{
          console.log(response);
        document.location.reload();
        }
      });
    }
}

export default UserQuestionReviewAjax;
