// expenses by budget chart
var myChart4 = new Chart(document.getElementById("expensesByBudgetChart"), {
    type: 'horizontalBar',
    data: {
      labels: budgetNames,
      datasets: [
        {
        label: '%',
        data: budgetPercentages,
        backgroundColor: budgetColors,
        borderColor: budgetColors,
        borderWidth: 1,
      }
      //continue with more dataset for stacked bar chart
    ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        // text: 'Predicted world population (millions) in 2050'
      },
      scales: {
        xAxes: [{
          barPercentage: 0.5,
          categoryPercentage: 1.0,
          gridLines: {
            drawBorder: false,
          },
          ticks: {
            fontSize: 15,
            fontColor: '#808080',
            padding: 10,
            min: 0,
            callback: function(value, index, values) {
              return value + '%';
            }
          }
        }],
        yAxes: [{
          barPercentage: 0.5,
          categoryPercentage: 1.0,
          gridLines: {
            drawBorder: false,
            display: false,

          },
          ticks: {
            beginAtZero: true,
            fontSize: 15,
            fontColor: '#808080',
            maxTicksLimit: 5,
            
            
          }
        }]
      },
      
    }
});