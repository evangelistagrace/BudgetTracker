//expenses by category chart
var ctx2 = document.getElementById('expensesByCategoryChart').getContext('2d');
var myChart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: budgetNames,
        datasets: [{
            label: '',
            data: expenseAngles,
            backgroundColor: budgetColors,
            borderColor: budgetColors,
            borderWidth: 2
            
        }]
    },
    options: {
        
        legend: {
            position: 'bottom'
        }
    }
});