//budget chart
var ctx = document.getElementById('budgetsChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: budgetNames,
        datasets: [{
            label: '',
            data: budgetAngles, //array passed from personalBudgets.php script
            backgroundColor: budgetColors,
            borderColor: budgetColors,
            borderWidth: 2
        }]
    },
    options: {
        legend: {
            position: 'bottom'
        },
        title: {
            display: true,
            text: 'My Budget Allocation',
            fontFamily: "'Varela Round', sans-serif",
            fontSize: 17,
            fontColor: 'grey'
        }
    }
});

