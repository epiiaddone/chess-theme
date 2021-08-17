import $ from 'jquery';

class RememberReviewsAjax{

    constructor(){
      this.addBtn = document.getElementById("addRememberToReviewsBtn");
      if(!this.addBtn) return;
      this.removeBtn = document.getElementById("removeRememberFromReviewsBtn");
      this.resetBtn = document.getElementById("resetRememberButton");
      this.confDiv = document.getElementById("resetRememberButtonConf");
      this.resetYesBtn = document.getElementById("resetRememberButtonYes");
      this.resetNoBtn = document.getElementById("resetRememberButtonNo");
      this.events();
    }

    events(){
      let _this = this;
      this.addBtn.addEventListener("pointerdown", function (event) {_this.addRemember(_this); });
      this.removeBtn.addEventListener("pointerdown", function (event) {_this.removeRemember(_this); });
      this.resetBtn.addEventListener("pointerdown", function (event) {_this.showConf(_this); });
      this.resetYesBtn.addEventListener("pointerdown", function (event) {_this.resetYes(_this); });
      this.resetNoBtn.addEventListener("pointerdown", function (event) {_this.hideConf(_this); });
    }

    addRemember(){
    this.addBtn.style.display="none";
    this.removeBtn.style.display="block";

    let remember_level = document.getElementById('vis_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/addUserRememberProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'remember_level':remember_level
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
    }

    removeRemember(){
    this.addBtn.style.display="block";
    this.removeBtn.style.display="none";

    let remember_level = document.getElementById('vis_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/removeUserRememberProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'remember_level':remember_level
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
    }

    resetYes(){

    let remember_level = document.getElementById('vis_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;
    this.hideConf();

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/resetUserRememberProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'remember_level':remember_level
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });

      location.reload();
    }

    showConf(){
      this.confDiv.style.display="flex";
      this.resetBtn.style.display="none";
    }
    hideConf(){
      this.confDiv.style.display="none";
      this.resetBtn.style.display="block";
    }

}

export default RememberReviewsAjax;
