console.log("js file loaded");

//reminder checkboxes and progress
var checkboxes = Array.from(document.querySelectorAll('.checkbox'));
var countChecked = 0;
var totalCheckbox = checkboxes.length;
var progressPercentage = 0;
var progressBar = document.querySelector('.progress-reminder');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function (e) {
        if (this.checked) {
            console.log("checked");
            var pseudoCheck = e.target.nextSibling;
            //create tick
            var tick = document.createElement('i');
            tick.className = 'fas';
            tick.classList.add('fa-check');
            pseudoCheck.appendChild(tick);
            countChecked++;
        
        } else if($("input[type='checkbox']:not(:checked)")) {
            var pseudoChecked = e.target.nextSibling.firstChild;
            pseudoChecked.parentNode.removeChild(pseudoChecked);
            countChecked--;
        }

        progressPercentage = countChecked * (1/totalCheckbox) * 100;
        progressBar.style.width = progressPercentage + '%';
    
    });
});

//settings radio options
function settingRadio() {
    var radioBtnChecked = document.querySelector("input[type='radio']:checked");
    var radioBtnNotChecked = Array.from(document.querySelectorAll("input[type='radio']:not(checked)"));

    var pseudoCheck = radioBtnChecked.nextSibling;
    var circle = document.createElement('i');
    circle.className = 'fas';
    circle.classList.add('fa-circle');
    pseudoCheck.appendChild(circle);

    radioBtnNotChecked.forEach(radioBtn => {
        console.log("unchecked");
        if (radioBtn.nextSibling.firstChild.contains(circle)) {
            var pseudoChecked = radioBtn.nextSibling.firstChild;
            pseudoChecked.parentNode.removeChild(pseudoChecked);
        }
        
    })
}



// radioBtns.forEach(radioBtn => {
//     radioBtn.addEventListener('change', function (e) {
//         if (radioBtn.checked) {
//             console.log("checked");
//             var pseudoCheck = e.target.nextSibling;
//             //create tick
//             var circle = document.createElement('i');
//             circle.className = 'fas';
//             circle.classList.add('fa-circle');
//             pseudoCheck.appendChild(circle);
        
//         } else if($("input[type='radio']:not(:checked)")){
//             console.log("unchecked");
            
//             var pseudoChecked = e.target.nextSibling.firstChild;
//             pseudoChecked.parentNode.removeChild(pseudoChecked);
//         }
    
//     });
// });


//toggle sidebar
function toggleSidebar() {
    $(".sidebar").toggleClass('collapsed');
    $(".col-10-body").toggleClass('collapsed');
}

//trigger tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});




//expenses chart
var ctx = document.getElementById('expensesChart').getContext('2d');
var myChart = new Chart(ctx, {
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
                'rgba(134, 192, 230, 0.5)',
            ],
            borderColor: [
                'rgba(92, 219, 149, 1)',
                'rgba(155, 133, 230, 1)',
                'rgba(173, 228, 151, 1)',
                'rgba(185, 227, 198, 1)',
                'rgba(134, 192, 230, 1)',
            ],
            borderWidth: 2,
            
        }]
    },
    options: {
        
        legend: {
            position: 'bottom'
        }
    }
});


//expenses by day chart
var ctx = document.getElementById('expensesByDayChart').getContext('2d');
var myChart = new Chart(ctx, {
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
            borderWidth: 2,
            
        }]
    },
    options: {
        
        legend: {
            position: 'bottom'
        }
    }
});



// activate clicked menu link state
const links = Array.from(document.querySelectorAll('.menu-item a'));

links.forEach((link) => {
  link.addEventListener('click', (e) => {
    // console.log("forEach worked");
    //remove active class from all other elements
    links.forEach((link) => {
       if(link.classList.contains('active')){
        link.classList.remove('active');
       }
      //add active class to target element
    e.target.classList.add('active');
    })
    
  });
});


 

// 
// console.log(totalCheckbox);



// //popup box
// const popupBtn = document.querySelector('.add-btn'); //button to trigger popup
// const popup = document.querySelector('.popup'); //popup content
// const popupClose = document.querySelector('.close-btn'); //popup close button

// popupBtn.onclick = function () {
//     popup.style.display = "block";
// }

// popupClose.onclick = function () {
//     popup.style.display = "none";
// }


// window.onclick = function (event) {
//     if (event.target == popup) {
//         popup.style.display = "none";
//     }
// }