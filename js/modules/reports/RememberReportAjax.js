import $ from 'jquery';

class RememberReportAjax{

    constructor(){
      this.form = document.getElementById("rememberReportForm");
      this.showButton = document.getElementById("rememberReportShowButton");
      if(!this.form) return;
      this.events();
    }

    events(){
      let _this = this;
      this.form.addEventListener("submit", function (event) {event.preventDefault();_this.sendTextData(_this); });
      this.showButton.addEventListener("pointerdown", function (event) {_this.showForm(_this); });
    }

    sendTextData(){
      let text = document.getElementById('rememberReportForMmsg').value;
      if(text===null || text==='') return;
      text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');

      let remember_id = document.getElementById('rememberID').innerHTML;
      let remember_level = document.getElementById('rememberLevel').innerHTML;
      let remember_number_in_set = document.getElementById('rememberNumberInSet').innerHTML;
      let user_uuid = document.getElementById('rememberUserUUID').innerHTML;

      this.form.style.display="none";

      $.ajax({
        /*
        beforeSend:(xhr)=>{
          xhr.setRequestHeader('X-WP-Nonce', kanjiAppData.nonce)
        },
        */
        url:chessAppData.root_url + '/wp-json/user/v1/saveRememberReport',
        type:'POST',
        data:{
          'user_uuid': user_uuid,//cant get it from the php for some reason
          'text' : text,
          'remember_id':remember_id,
          'remember_level':remember_level,
          'remember_number_in_set':remember_number_in_set,
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

export default RememberReportAjax;
