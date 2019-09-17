
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


//popup box
const popupBtn = document.querySelector('.add-btn'); //button to trigger popup
const popup = document.querySelector('.popup'); //popup content
const popupClose = document.querySelector('.close-btn'); //popup close button

popupBtn.onclick = function () {
    popup.style.display = "block";
}

popupClose.onclick = function () {
    popup.style.display = "none";
}


window.onclick = function (event) {
    if (event.target == popup) {
        popup.style.display = "none";
    }
}