import $ from 'jquery';

class LessonReportAjax{

    constructor(){
      this.form = document.getElementById("lessonReportForm");
      this.showButton = document.getElementById("lessonReportShowButton");
      if(!this.form) return;
      this.events();
    }

    events(){
      let _this = this;
      this.form.addEventListener("submit", function (event) {event.preventDefault();_this.sendTextData(_this); });
      this.showButton.addEventListener("pointerdown", function (event) {_this.showForm(_this); });
    }

    sendTextData(){
      let text = document.getElementById('lessonReportForMmsg').value;
      if(text===null || text==='') return;
      text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');

      let lesson_id = document.getElementById('lesson_id').innerHTML;
      let lesson_title = document.getElementById('lesson_display_title').innerHTML;
      let user_uuid = document.getElementById('user_uuid').innerHTML;

      this.form.style.display="none";

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/saveLessonReport',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'text' : text,
          'lesson_id':lesson_id,
          'lesson_title':lesson_title
        },
        success:(response)=>{//this is never reached regardless of succes or failure
          console.log(response);
        },
        error:(response)=>{
          console.log(response);
        }
      });
    }

    showForm(){
      this.form.style.display="block";
      this.showButton.style.display="none";
    }

}

export default LessonReportAjax;
