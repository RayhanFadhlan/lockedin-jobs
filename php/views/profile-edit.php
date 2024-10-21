<div class="container">
    <form action="/profile/edit" method="POST" class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Profile</h2>
            <p class="card-description">Update your company information</p>
        </div>

        <div class="form-group">
            <label for="company-name">Company Name</label>
            <div class="input-icon company">
                <input type="text" id="company-name" name="company_name" value="<?= htmlspecialchars($name['nama']) ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="company-location">Location</label>
            <div class="input-icon location">
                <input type="text" id="company-location" name="location" value="<?= htmlspecialchars($detail['lokasi']) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="company-about">About</label>
            <textarea id="company-about" name="about" rows="3" required><?= htmlspecialchars($detail['about']) ?></textarea>
        </div>

        <div class="button-group">
            <button type="button" id="cancel-btn" class="button button-secondary">Cancel</button>
            <button type="submit" class="button button-primary">Save Changes</button>
        </div>
    </form>
</div>

<script src="/public/scripts/profile-edit.js"></script>