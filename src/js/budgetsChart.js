//budget chart
var ctx = document.getElementById('budgetChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Food', 'Travel', 'Groceries'],
        datasets: [{
            label: '# of Votes',
            data: budgetAngles, //array passed from personalBudgets.php script
            backgroundColor: [
                'rgba(92, 219, 149, 0.5)',
                'rgba(155, 133, 230, 0.5)',
                'rgba(173, 228, 151, 0.5)'

            ],
            // borderColor: [
            //     'rgba(92, 219, 149, 1)',
            //     'rgba(155, 133, 230, 1)',
            //     'rgba(173, 228, 151, 1)'

            // ],
            borderWidth: 2
        }]
    },
    options: {
        legend: {
            position: 'bottom'
        }
    }
});