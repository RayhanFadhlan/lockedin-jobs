<div class="container">
    <button class="setting" id="editProfileBtn">Edit Profile</button>

    <div class="card">
        <h1 class="company-name"><?php echo $name['nama'] ?></h1>
        <p class="location"><?php echo $detail['lokasi'] ?></p>
    </div>

    <main class="card">
        <p class="about-title">About us</p>
        <p class="about"><?php echo $detail['about'] ?></p>
    </main>
</div>

<script src="/public/scripts/company-profile.js"></script>