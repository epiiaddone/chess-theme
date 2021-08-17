

class Chart1{

  constructor(){
    if(!document.getElementById('page-chart1')) return;
    this.ctx = document.getElementById('page-chart1').getContext('2d');
    this.screenWidth = screen.width;
    this.buildChart(this.screenWidth);
  }

  getAspectRatio(screenWidth){
    if(screenWidth>1009) return 2.5;
    else if(screenWidth>799) return 2;
    else return 1;
  }

  buildChart(screenWidth){
    let aspectRatio = this.getAspectRatio(screenWidth);

    Chart.defaults.global.defaultFontColor = 'black';
    var chart = new Chart(this.ctx, {
        // The type of chart we want to create
        type: 'line',
         // The data for our dataset
        data: {
            labels: ['1','2','3','4'],
            datasets: [{
                label: 'Win',
                borderColor: 'rgb(51, 204, 51)',
                backgroundColor: 'rgb(51, 204, 51)',
                pointStyle:'circle',
                pointRadius:5,
                data: [,1487],
         fill:true,
            },
       {
         label: 'Draw',
                borderColor: 'rgb(51, 153, 255)',
                backgroundColor: 'rgb(51, 153, 255)',
                pointStyle:'rectangle',
                pointRadius:10,
                data: [,,,],
         fill:false,
         },
       {
         label: 'Lose',
                borderColor: 'rgb(255, 0, 0)',
                backgroundColor: 'rgb(255, 0, 0)',
                pointStyle:'cross',
                rotation:45,
                pointRadius:10,
                data: [1532,,1383,1478],
         fill:false,
         }
       ]
        },
    //1600, 1750, 1900## 2000, 2100, 2200,    2250, 2300, 2350, 2400
        // Configuration options go here
        options: {
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    fontColor: 'black',
           fontSize:16,
                },
         position: 'bottom',
            },
       aspectRatio:aspectRatio,
       title: {
         display:true,
         fontSize:20,
         text:'FIDE Rated Games',
         fontColor:'black',
       },scales: {
         yAxes: [{
           scaleLabel: {
           display: false,
           labelString: "Opponent FIDE Rating"
           }
         }],
         xAxes: [{
           scaleLabel: {
           display: false,
           labelString: "Game Number"
           }
         }]
       },
       spanGaps:true,
     },//end of options
    });
  }

}

export default Chart1;
