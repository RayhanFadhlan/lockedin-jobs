document.addEventListener('DOMContentLoaded', function() {
    const burgerMenu = document.querySelector('.burger-menu');
    const navbarRight = document.querySelector('.navbar-right');

    burgerMenu.addEventListener('click', function() {
        navbarRight.classList.toggle('show');
    });

    // Close the menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!navbarRight.contains(event.target) && !burgerMenu.contains(event.target)) {
            navbarRight.classList.remove('show');
        }
    });
    
    const profileDropdown = document.getElementById('profileDropdown');
    const profileDropdownMenu = document.getElementById('profileDropdownMenu');

    if (profileDropdown && profileDropdownMenu) {
        profileDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            profileDropdownMenu.classList.toggle('show');
        });

        // Close the dropdown when clicking outside of it
        document.addEventListener('click', function(e) {
            if (!profileDropdown.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                profileDropdownMenu.classList.remove('show');
            }
        });
    }
});