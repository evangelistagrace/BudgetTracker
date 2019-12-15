//expenses chart
var ctx2 = document.getElementById('expensesByCategoryChart').getContext('2d');
var myChart2 = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Food', 'Clothing', 'Travel', 'Gifts', 'Misc'],
        datasets: [{
            label: '# of Votes',
            data: [12, 8, 3, 5, 2],
            backgroundColor: [
                'rgba(92, 219, 149, 0.5)',
                'rgba(155, 133, 230, 0.5)',
                'rgba(173, 228, 151, 0.5)',
                'rgba(185, 227, 198, 0.5)',
                'rgba(134, 192, 230, 0.5)'
            ],
            borderColor: [
                'rgba(92, 219, 149, 1)',
                'rgba(155, 133, 230, 1)',
                'rgba(173, 228, 151, 1)',
                'rgba(185, 227, 198, 1)',
                'rgba(134, 192, 230, 1)'
            ],
            borderWidth: 2
            
        }]
    },
    options: {
        
        legend: {
            position: 'bottom'
        }
    }
});