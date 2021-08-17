import $ from 'jquery';

class TacticsReviewsAjax{

    constructor(){
      this.addBtn = document.getElementById("addTacticsToReviewsBtn");
      if(!this.addBtn) return;
      this.removeBtn = document.getElementById("removeTacticsFromReviewsBtn");
      this.resetBtn = document.getElementById("resetTacticsButton");
      this.confDiv = document.getElementById("resetTacticsButtonConf");
      this.resetYesBtn = document.getElementById("resetTacticsButtonYes");
      this.resetNoBtn = document.getElementById("resetTacticsButtonNo");
      this.events();
    }

    events(){
      let _this = this;
      this.addBtn.addEventListener("pointerdown", function (event) {_this.addTactics(_this); });
      this.removeBtn.addEventListener("pointerdown", function (event) {_this.removeTactics(_this); });
      this.resetBtn.addEventListener("pointerdown", function (event) {_this.showConf(_this); });
      this.resetYesBtn.addEventListener("pointerdown", function (event) {_this.resetYes(_this); });
      this.resetNoBtn.addEventListener("pointerdown", function (event) {_this.hideConf(_this); });
    }

    addTactics(){
    this.addBtn.style.display="none";
    this.removeBtn.style.display="block";
    document.getElementById('loading-display').style.display="block";
    let tactics_level = document.getElementById('tactics_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/addUserTacticsProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'tactics_level':tactics_level
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
      setTimeout(function(){document.getElementById('loading-display').style.display="none";}, 4000);
    }

    removeTactics(){
    this.addBtn.style.display="block";
    this.removeBtn.style.display="none";
    document.getElementById('loading-display').style.display="block";
    let tactics_level = document.getElementById('tactics_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/removeUserTacticsProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'tactics_level':tactics_level
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
      setTimeout(function(){document.getElementById('loading-display').style.display="none";}, 4000);
    }

    resetYes(){
    let tactics_level = document.getElementById('tactics_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;
    document.getElementById('loading-display').style.display="block";
      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/resetUserTacticsProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'tactics_level':tactics_level
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
      setTimeout(function(){document.getElementById('loading-display').style.display="none";}, 4000);
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

export default TacticsReviewsAjax;
