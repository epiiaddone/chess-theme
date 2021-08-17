import $ from 'jquery';

class VisReportAjax{

    constructor(){
      this.form = document.getElementById("visReportForm");
      this.showButton = document.getElementById("visReportShowButton");
      if(!this.form) return;
      this.events();
    }

    events(){
      let _this = this;
      this.form.addEventListener("submit", function (event) {event.preventDefault();_this.sendTextData(_this); });
      this.showButton.addEventListener("pointerdown", function (event) {_this.showForm(_this); });
    }

    sendTextData(){
      let text = document.getElementById('visReportForMmsg').value;
      if(text===null || text==='') return;
      text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');

      let vis_id = document.getElementById('vis_id').innerHTML;
      let vis_level = document.getElementById('vis_level').innerHTML;
      let vis_number_in_set = document.getElementById('number_seen').innerHTML;
      let user_uuid = document.getElementById('user_uuid').innerHTML;

      this.form.style.display="none";

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/saveVisReport',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'text' : text,
          'vis_id':vis_id,
          'vis_level':vis_level,
          'vis_number_in_set':vis_number_in_set,
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

export default VisReportAjax;
