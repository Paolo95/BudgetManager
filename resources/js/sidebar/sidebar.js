document.addEventListener('DOMContentLoaded', function() {
    var mainMenuLinks = document.querySelectorAll('.main-menu-link');

    mainMenuLinks.forEach(function(link) {

        link.addEventListener('click', function(e) {
            var parentMenuItem = this.parentElement;
            var submenu = parentMenuItem.querySelector('.submenu');
            
            if (submenu) {
                e.preventDefault();
                parentMenuItem.classList.toggle('selected');

                if (submenu.classList.contains('hidden')) {
                    submenu.classList.remove('hidden');
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                } else {
                    submenu.classList.add('hidden');
                    submenu.style.maxHeight = '0';
                }
            }
        });
    });

});
