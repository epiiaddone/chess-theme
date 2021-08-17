import $ from 'jquery';

class UserVisAjax{

    constructor(){
      if(!document.getElementById('vis-review-identifier')) return;
      this.falseBtn = document.getElementById("someWrong");
      this.correctBtn = document.getElementById("allCorrect");
      this.events();
    }

    events(){
      let _this = this;
      this.falseBtn.addEventListener("pointerdown", function(event){_this.sendData('false')});
      this.correctBtn.addEventListener("pointerdown", function(event){_this.sendData('correct')});
    }

    sendData(button_hit){

    let vis_id = document.getElementById('vis_id').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;
    let vis_level = document.getElementById('vis_level').innerHTML;

    document.getElementById('loading-display').style.display='block';

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/updateUserVis',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'vis_id':vis_id,
          'button_hit':button_hit,
          'vis_level':vis_level
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

export default UserVisAjax;
