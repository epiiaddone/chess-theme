import $ from 'jquery';

class LessonReviewsAjax{

    constructor(){
      this.addBtn = document.getElementById("addLessonToReviewsBtn");
      if(!this.addBtn) return;
      this.removeBtn = document.getElementById("removeLessonFromReviewsBtn");
      this.resetBtn = document.getElementById("resetLessonBtn");
      this.markReadBtn = document.getElementById("markLessonAsReadBtn");
      this.markNotReadBtn = document.getElementById("markLessonAsNotReadBtn");
      this.confDiv = document.getElementById("resetLessonButtonConf");
      this.resetYesBtn = document.getElementById("resetLessonButtonYes");
      this.resetNoBtn = document.getElementById("resetLessonButtonNo");
      this.events();
    }

    events(){
      let _this = this;
      this.addBtn.addEventListener("pointerdown", function (event) {_this.addLesson(_this); });
      this.removeBtn.addEventListener("pointerdown", function (event) {_this.removeLesson(_this); });
      this.resetBtn.addEventListener("pointerdown", function (event) {_this.showConf(_this); });
      this.resetYesBtn.addEventListener("pointerdown", function (event) {_this.resetYes(_this); });
      this.resetNoBtn.addEventListener("pointerdown", function (event) {_this.hideConf(_this); });
      this.markReadBtn.addEventListener("pointerdown", function (event) {_this.markRead(_this); });
      this.markNotReadBtn.addEventListener("pointerdown", function (event) {_this.markNotRead(_this); });
    }

    markRead(){
      this.markReadBtn.style.display = "none";
      this.markNotReadBtn.style.display="block";
      document.getElementById('loading-display').style.display="block";

      let lesson_id = document.getElementById('lesson_id').innerHTML;
      let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/updateLessonRead',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'lesson_id':lesson_id,
          'read':true
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

    markNotRead(){
      this.markReadBtn.style.display = "block";
      this.markNotReadBtn.style.display= "none";
      document.getElementById('loading-display').style.display="block";

      let lesson_id = document.getElementById('lesson_id').innerHTML;
      let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/updateLessonRead',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'lesson_id':lesson_id,
          'read':false//this will be passed as a string not a boolean!!!
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

    addLesson(){
    this.addBtn.style.display="none";
    this.removeBtn.style.display="block";
    this.markReadBtn.style.display="none";
    this.markNotReadBtn.style.display="block";
    document.getElementById('loading-display').style.display="block";

    let lesson_id = document.getElementById('lesson_id').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/addUserLesson',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'lesson_id':lesson_id
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

    removeLesson(){
    this.addBtn.style.display="block";
    this.removeBtn.style.display="none";
    document.getElementById('loading-display').style.display="block";

    let lesson_id = document.getElementById('lesson_id').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/removeUserLesson',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'lesson_id':lesson_id
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

    let lesson_id = document.getElementById('lesson_id').innerHTML;
    let user_uuid = document.getElementById('user_uuid').innerHTML;
    document.getElementById('loading-display').style.display="block";

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/resetUserLesson',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'lesson_id':lesson_id
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
      this.hideConf();
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

export default LessonReviewsAjax;
