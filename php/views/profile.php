<div class="container">
    <div class="profile-card">
        <div class="profile-header">
            <img src="../public/images/profile.png" alt="Profile photo" class="profile-photo">
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