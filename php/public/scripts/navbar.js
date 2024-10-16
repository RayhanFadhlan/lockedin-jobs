document.addEventListener('DOMContentLoaded', function() {
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