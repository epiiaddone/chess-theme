import $ from 'jquery';

class QuestionReportAjax{

    constructor(){
      this.form = document.getElementById("questionReportForm");
      this.showButton = document.getElementById("questionReportShowButton");
      if(!this.form) return;
      this.events();
    }

    events(){
      let _this = this;
      this.form.addEventListener("submit", function (event) {event.preventDefault();_this.sendTextData(_this); });
      this.showButton.addEventListener("pointerdown", function (event) {_this.showForm(_this); });
    }

    sendTextData(){
      let text = document.getElementById('questionReportForMmsg').value;
      if(text===null || text==='') return;
      text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');

      let question_id = document.getElementById('question_id').innerHTML;
      let question_title = document.getElementById('question_title').innerHTML;
      let user_uuid = document.getElementById('user_uuid').innerHTML;

      this.form.style.display="none";

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/saveQuestionReport',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'text' : text,
          'question_id':question_id,
          'question_title':question_title
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

export default QuestionReportAjax;
