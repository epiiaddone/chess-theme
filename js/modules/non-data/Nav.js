
class Nav{

  constructor(){
    this.debug = true;
    this.nav = $('#nav--login');
    if(!this.nav) return;
    this.buttons = this.nav.children();
    if(this.debug) console.log(this.buttons);
    this.events();
  }

  events(){
    this.setNavLevels();
  }

  setNavLevels(){
    for(let i=0; i<this.buttons.length; i++){
      let button = this.buttons[i];
      if(this.debug) console.log(button);
      if(button.className.includes("loginColor-hover")) return;
      this.setButtonEvents(button);
    }
  }

  setButtonEvents(button){
    button.addEventListener('pointerdown', this.toggleClass.bind(button));
  }

  toggleClass(button){
    let levelsDiv = this.children[1];
    let currentClassName = levelsDiv.className;
    let classNameToToggle = ' nav--levels__show';
    if(currentClassName.includes(classNameToToggle)){
      currentClassName = currentClassName.replace(classNameToToggle, '');
    }else{
      currentClassName = currentClassName + classNameToToggle;
    }
    levelsDiv.className = currentClassName;
  }


}


export default Nav;
