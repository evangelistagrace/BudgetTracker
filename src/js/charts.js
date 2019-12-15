

//expenses by day chart
var ctx3 = document.getElementById('expensesByDayChart').getContext('2d');
var myChart3 = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10',
            '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
            '21', '22','23','24','25','26','27','28','29','30','31'],
        datasets: [{
            label: 'Expenses',
            data: [47,
                23,
                31,
                15,
                33,
                82,
                51,
                72,
                39,
                44,
                20,
                21,
                26,
                91,
                41,
                43,
                50,
                27,
                94,
                75,
                25,
                66,
                51,
                42,
                83,
                49,
                28,
                97,
                59,
                58,
                48,               
                ],
            backgroundColor: 'rgba(255,153,123,.5)',
            borderColor: 'rgba(255,153,123,.9)',
            borderWidth: 2
            
        }]
    },
    options: {
        
        legend: {
            position: 'bottom'
        }
    }
});