<div class="container">
    <form action="/profile/edit" method="post" class="card">
        <label for="company-name">Company Name</label>
        <input type="text" id="company-name" name="company_name" value="<?= $name['nama'] ?>" required>
        
        <label for="company-location">Location</label>
        <input type="text" id="company-location" name="location" value="<?= $detail['lokasi'] ?>" required>

        <label for="company-about">About</label>
        <input type="text" id="company-about" name="about" rows="3" value="<?= $detail['about'] ?>" required>

        <button type="button" id="cancel-btn" class="primary-btn">Cancel</button>
        <button type="submit" class="primary-btn">Save</button>
    </form>
</div>

<script src="/public/scripts/profile-edit.js"></script>