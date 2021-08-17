import $ from 'jquery';

class ReviewSummary{
  constructor(){
    this.debug=true;
    if(this.debug) console.log("inside ReviewSummary constructor");
    this.container = document.getElementById('reviewsummary');
    if(!this.container) return;
    this.reviewData = localStorage.getItem('chess100to1reviewData');
    if(!this.reviewData){
      this.show_no_review_data();
      return;
    }
  }

  show_no_review_data(){
    let newDiv = document.createElement('div');
    newDiv.innerHTML = "No review data to show";
    this.container.appendChild(newDiv);
  }


}

export default ReviewSummary;
