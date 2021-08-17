import $ from 'jquery';

class TacticReportAjax{

    constructor(){
      this.form = document.getElementById("tacticReportForm");
      this.showButton = document.getElementById("tacticReportShowButton");
      if(!this.form) return;
      this.events();
    }

    events(){
      let _this = this;
      this.form.addEventListener("submit", function (event) {event.preventDefault();_this.sendTextData(_this); });
      this.showButton.addEventListener("pointerdown", function (event) {_this.showForm(_this); });
    }

    sendTextData(){
      let text = document.getElementById('tacticReportForMmsg').value;
      if(text===null || text==='') return;
      text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');

      let tactic_id = document.getElementById('tactic_id').innerHTML;
      let tactic_level = document.getElementById('tactic_level').innerHTML;
      let tactic_number_in_set = document.getElementById('tactic_number_in_set').innerHTML;
      let user_uuid = document.getElementById('user_uuid').innerHTML;

      this.form.style.display="none";

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/saveTacticReport',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'text' : text,
          'tactic_id':tactic_id,
          'tactic_level':tactic_level,
          'tactic_number_in_set':tactic_number_in_set,
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

export default TacticReportAjax;
