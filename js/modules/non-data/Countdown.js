

class Countdown{

  constructor(){
    this.years = document.getElementById('t1');
    if(!this.years) return;
    this.months = document.getElementById('t2');
    this.days = document.getElementById('t3');
    this.setCountdown();
  }


  setCountdown(){

    const deadline = new Date('December 31, 2030');
    const dateToday = new Date();

    this.years.innerHTML = this.getYears(deadline,dateToday);
    this.months.innerHTML = this.getMonths(deadline,dateToday);
    this.days.innerHTML = this.getDays(deadline,dateToday);

  }

   getYears(deadline,dateToday){
    const deadlineYear = deadline.getFullYear();
    const dateTodayYear = dateToday.getFullYear();

    const deadlineMonth = deadline.getMonth();
    const dateTodayMonth = dateToday.getMonth();

    const deadlineDay = deadline.getDate();
    const dateTodayDay = dateToday.getDate();

    var years;

    if(deadlineMonth > dateTodayMonth || deadlineMonth == dateTodayMonth && deadlineDay > dateTodayDay){
    years = deadlineYear - dateTodayYear;
    }else{
    years = deadlineYear - dateTodayYear - 1;
    }
    return years;
  }

  getMonths(deadline,dateToday){
    const deadlineYear = deadline.getFullYear();
    const dateTodayYear = dateToday.getFullYear();

    const deadlineMonth = deadline.getMonth();
    const dateTodayMonth = dateToday.getMonth();

    const deadlineDay = deadline.getDate();
    const dateTodayDay = dateToday.getDate();

    var months;

    if(deadlineMonth > dateTodayMonth && deadlineDay >= dateTodayDay ){
    months = deadlineMonth - dateTodayMonth;
    }else if(deadlineMonth > dateTodayMonth && deadlineDay < dateTodayDay){
    months = deadlineMonth - dateTodayMonth - 1;
    }else if(deadlineMonth == dateTodayMonth && deadlineDay >= dateTodayDay){
    month = 0;
    }else if(deadlineMonth == dateTodayMonth && deadlineDay < dateTodayDay){
    months = 11;
    }else if(deadlineMonth < dateTodayMonth && deadlineDay >= dateTodayDay){
    month = 12 - (dateTodayMonth - deadlineMonth);
    }else if(deadlineMonth <dateTodayMonth && deadlineDay < dateTodayDay){
    month = 12 - (dateTodayMonth - deadlineMonth) - 1;
    }
    return months;
  }


 getDays(deadline,dateToday){
  const deadlineYear = deadline.getFullYear();
  const dateTodayYear = dateToday.getFullYear();

  const deadlineMonth = deadline.getMonth();
  const dateTodayMonth = dateToday.getMonth();

  const deadlineDay = deadline.getDate();
  const dateTodayDay = dateToday.getDate();

  var days;
  if(deadlineDay >= dateTodayDay){
  days = deadlineDay - dateTodayDay;
  }else{
  days = deadlineDay - dateTodayDay + getDaysInCurrentMonth(dateTodayMonth,dateTodayYear);
  }
  return days;
}

   getDaysInCurrentMonth(dateTodayMonth,dateTodayYear){
      var days;

      switch(dateTodayMonth){
      case 0: days=31; break;
      case 1: days=0; break;
      case 2: days=31; break;
      case 3: days=30; break;
      case 4: days=31; break;
      case 5: days=30; break;
      case 6: days=31; break;
      case 7: days=31; break;
      case 8: days=30; break;
      case 9: days=31; break;
      case 10: days=30; break;
      case 11: days=31; break;
      }

      if(days==0 && dateTodayYear % 4 == 0 && (dateTodayYear % 100 !==0 || dateTodayYear % 400==0)){
      days = 29;
      }else if(days==0){
      days = 28;
      }

      return days;
  }


}
export default Countdown;
