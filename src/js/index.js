console.log("js file loaded");

// to-do list checkbox and progess bar
var checkboxes = Array.from(document.querySelectorAll('.fa-check-square')).length;
var countChecked = 0;
var totalCheckbox = Array.from(document.querySelectorAll('.reminder-check')).length;
var progressPercentage = 0;
var progressBar = document.querySelector('#progress-reminder');
progressPercentage = checkboxes * (1/totalCheckbox) * 100;
progressBar.style.width = progressPercentage + '%';


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

//toggle sidebar
function toggleSidebar() {
    $(".sidebar").toggleClass('collapsed');
    $(".col-10-body").toggleClass('collapsed');
}

//trigger tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});




