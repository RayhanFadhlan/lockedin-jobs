<div class="container">
    <button class="setting" id="editProfileBtn">Edit Profile</button>

    <div class="card">
        <h1 class="company-name"><?= $name['nama'] ?></h1>
        <p class="location"><?= $detail['lokasi'] ?></p>
    </div>

    <main class="card">
        <p class="about-title">About us</p>
        <p class="about"><?= $detail['about'] ?></p>
    </main>
</div>

<script src="/public/scripts/profile.js"></script>