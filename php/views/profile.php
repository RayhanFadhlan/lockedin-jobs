<div class="container">
    <div class="profile-card">
        <div class="profile-header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" id="company-accent-4" class="profile-photo">
            <path fill="#e7e2dc" d="M0 0h128v128H0z"></path>
            <path fill="#9db3c8" d="M48 16h64v112H48z"></path>
            <path fill="#788fa5" d="M16 80h32v48H16z"></path>
            <path fill="#56687a" d="M48 80h32v48H48z"></path>
            </svg>
            <button class="setting" id="editProfileBtn">Edit Profile</button>
        </div>
        <div class="profile-content">
            <h1 class="profile-name">
                <?= htmlspecialchars($name['nama']) ?>
            </h1>
            <p class="profile-location"><?= htmlspecialchars($detail['lokasi']) ?>
            <p class="profile-headline"><?= htmlspecialchars($detail['about']) ?></p>
        </div>
    </div>
</div>

<script src="/public/scripts/profile.js"></script>