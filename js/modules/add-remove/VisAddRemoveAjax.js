import $ from 'jquery';

class VisReviewsAjax{

    constructor(){
      this.addBtn = document.getElementById("addVisToReviewsBtn");
      if(!this.addBtn) return;
      this.removeBtn = document.getElementById("removeVisFromReviewsBtn");
      this.resetBtn = document.getElementById("resetVisButton");
      this.confDiv = document.getElementById("resetVisButtonConf");
      this.resetYesBtn = document.getElementById("resetVisButtonYes");
      this.resetNoBtn = document.getElementById("resetVisButtonNo");
      this.events();
    }

    events(){
      let _this = this;
      this.addBtn.addEventListener("pointerdown", function (event) {_this.addVis(_this); });
      this.removeBtn.addEventListener("pointerdown", function (event) {_this.removeVis(_this); });
      this.resetBtn.addEventListener("pointerdown", function (event) {_this.showConf(_this); });
      this.resetYesBtn.addEventListener("pointerdown", function (event) {_this.resetYes(_this); });
      this.resetNoBtn.addEventListener("pointerdown", function (event) {_this.hideConf(_this); });
    }

    addVis(){
    this.addBtn.style.display="none";
    this.removeBtn.style.display="block";

    let vis_level = document.getElementById('vis_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/addUserVisProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'vis_level':vis_level
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
    }

    removeVis(){
    this.addBtn.style.display="block";
    this.removeBtn.style.display="none";

    let vis_level = document.getElementById('vis_level').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/deactivateUserVisProg',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'vis_level':vis_level
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

          let vis_level = document.getElementById('vis_level').innerHTML;
          let user_uuid = document.getElementById('user_uuid').innerHTML;
          this.hideConf();

            $.ajax({
              /*
              beforeSend:(xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
              },
              */
              url:chessAppData.root_url + '/wp-json/user/v1/resetUserVisProg',
              type:'POST',
              data:{
                'user_uuid': user_uuid,//cant get it from the php for some reason
                'vis_level':vis_level
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

export default VisReviewsAjax;
