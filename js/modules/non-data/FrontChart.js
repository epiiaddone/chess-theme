

class FrontChart{

  constructor(){
    if(!document.getElementById('myChart')) return;
    this.ctx = document.getElementById('myChart').getContext('2d');
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
            labels: ['2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030','2031'],
            datasets: [{
                label: 'Year 1: +300',
                borderColor: 'rgb(31, 161, 11)',
                backgroundColor: 'rgb(31, 161, 11)',
                data: [1277, 1600,],
         fill:false,
            },
       {
         label: 'Year 2, 3: +150',
                borderColor: 'rgb(212, 192, 15)',
                backgroundColor: 'rgb(212, 192, 15)',
                data: [,1600, 1750, 1900,],
         fill:false,
         },
       {
         label: 'Year 4, 5, 6: +100',
                borderColor: 'rgb(245, 170, 7)',
                backgroundColor: 'rgb(245, 170, 7)',
                data: [,,,1900,2000, 2100, 2200],
         fill:false,
         },
       {
         label: 'Year 7, 8, 9, 10: +50',
                borderColor: 'rgb(245, 55, 7)',
                backgroundColor: 'rgb(245, 55, 7)',
                data: [,,,,,, 2200,2250, 2300, 2350, 2400],
         fill:false,
       },
       {
           label: 'Actual',
           borderColor: 'rgb(44,151,222)',
           backgroundColor: 'rgb(44,151,222)',
           data: [1277,],
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
         text:'FIDE Rating Targets',
         fontColor:'black',
       },
       scales: {
         yAxes: [{
           scaleLabel: {
           display: false,
           labelString: "FIDE Rating"
           }
         }],
         xAxes: [{
           scaleLabel: {
           display: false,
           labelString: "Year Start"
           }
         }]
       },
        },
    });

  }

}

export default FrontChart;
