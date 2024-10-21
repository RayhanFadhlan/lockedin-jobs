const companyProfile = document.getElementById('profile');

const editBtn = document.getElementById('editProfileBtn');
editBtn.addEventListener('click', () => {
    document.location.href = '/profile/edit';
})