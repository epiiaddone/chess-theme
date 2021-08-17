import $ from 'jquery';

class UserTacticReviewAjax{

    constructor(){
      if(!document.getElementById('tactics-review-identifier')) return;
      this.falseBtn = document.getElementById("falseButton");
      this.correctBtn = document.getElementById("correctButton");
      this.events();
    }

    events(){
      let _this = this;
      this.falseBtn.addEventListener("pointerdown", function(event){_this.sendData('false')});
      this.correctBtn.addEventListener("pointerdown", function(event){_this.sendData('correct')});
    }

    sendData(button_hit){

    let tactic_id = document.getElementById('tactic_id').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;
    let tactics_level = document.getElementById('tactic_level').innerHTML;

    document.getElementById('loading-display').style.display='block';

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/updateUserTacticReview',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'tactic_id':tactic_id,
          'button_hit':button_hit,
          'tactics_level':tactics_level,
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
         location.reload(true);
        },
        error:(response)=>{
          console.log(response);
          location.reload(true);
        }
      });
    }
}

export default UserTacticReviewAjax;
