import $ from 'jquery';

class ResetReviewsAjax{

    constructor(){
      this.resetButton = document.getElementById("resetReviewsButton");
      if(!this.resetButton) return;
      this.events();
    }

    events(){
      this.resetButton.addEventListener("pointerdown", this.sendResetData);
    }

    sendResetData(){
      document.getElementById('loading-display').style.display="block";
      let level = document.getElementById('resetSelectLevel').value;
      let type = document.getElementById('resetSelectType').value;
      let user_uuid = document.getElementById('user_uuid').innerHTML;

    $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/resetReviews',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'level': level,
          'type': type
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });

      setTimeout(function(){document.getElementById('loading-display').style.display="none";}, 6000);
    }

}

export default ResetReviewsAjax;
