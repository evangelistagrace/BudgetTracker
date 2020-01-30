
var numberWithCommas = function(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

console.log(mainArr);

//expenses by day chart
var ctx3 = document.getElementById('expensesByDayChart').getContext('2d');
var myChart3 = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10',
            '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
            '21', '22','23','24','25','26','27','28','29','30','31'],
        datasets: mainArr,
    },
    options: {
        
        legend: {
            display: true,
        },
        tooltips: {
					mode: 'label',
          callbacks: {
            label: function(tooltipItem, data) { 
              return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
            },
            title: function(tooltipItem, data) {
              console.log(tooltipItem);
              return "RM " + expenseAmountsByDay[tooltipItem[0].index];
            }
          }
         },
        scales: {
            xAxes: [{
              stacked: true,
            }],
            yAxes: [{
              stacked: true,
              ticks: {
                callback: function(value) { return numberWithCommas(value); },
               }, 
              barPercentage: 0.5,
              categoryPercentage: 1.0,
              ticks: {
                fontSize: 15,
                fontColor: '#808080',
                padding: 10,
                min: 0,
                callback: function(value, index, values) {
                  return 'RM ' + value;
                }
              }
            }]
          },
          plugins: [{
            beforeInit: function (chart) {
              chart.data.labels.forEach(function (value, index, array) {
                var a = [];
                a.push(value.slice(0, 5));
                var i = 1;
                while(value.length > (i * 5)){
                  a.push(value.slice(i * 5, (i + 1) * 5));
                    i++;
                }
                array[index] = a;
              })
            }
          }]
        }
});

