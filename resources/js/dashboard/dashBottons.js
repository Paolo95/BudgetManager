document.addEventListener('DOMContentLoaded', function() {
    var mainButton = document.getElementById('main-button');
    var mainIcon = document.getElementById('main-icon');
    var toggled = false;

    mainButton.addEventListener('click', function(event) {
        event.preventDefault();
        document.body.classList.toggle('show-buttons');
        toggled = !toggled;
        if (toggled) {
            mainIcon.classList.remove('fa-plus');
            mainIcon.classList.add('fa-times');
        } else {
            mainIcon.classList.remove('fa-times');
            mainIcon.classList.add('fa-plus');
        }
    });
});
