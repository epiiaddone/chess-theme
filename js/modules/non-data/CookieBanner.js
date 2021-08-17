

class CookieBanner{

  constructor(){
    this.banner = document.getElementById('cookie-banner');
    if(!this.banner) return;
    this.button = document.getElementById('cookie-button');
    if(!this.button) return;
    if(this.isCookieAccepted()) return;
    this.banner.style.display='flex';
    this.events();
  }

  isCookieAccepted(){
    if(localStorage.getItem('cookie-consent')=='present'){
      console.log("cookie-consent found");
      return true;
    }
    return false;
  }

  events(){
    let _this = this;
    this.button.addEventListener('pointerdown', _this.setCookieConsent);
  }

  setCookieConsent(){
    localStorage.setItem('cookie-consent', 'present');
    document.getElementById('cookie-banner').style.display="none";
  }


}

export default CookieBanner;
