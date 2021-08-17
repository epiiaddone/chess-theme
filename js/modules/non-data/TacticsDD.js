

class TacticsDD{

  constructor(){
    this.heroBtn = document.getElementById('tacticsHeroBtn');
    if(!this.heroBtn) return;
    this.tacticsLevelDiv = document.getElementById('tactics-level-div');
    this.tacticsLevel = this.tacticsLevelDiv.innerHTML;
    this.events();
  }

  events(){
    let _this = this;
    this.heroBtn.addEventListener("pointerdown", function (event) {_this.goToTacticsPage(_this); });
  }

  goToTacticsPage(_this){
    location.href="/tactics/?level=" + _this.tacticsLevel;
  }
}

export default TacticsDD;
