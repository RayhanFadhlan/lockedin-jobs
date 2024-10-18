<div class="container">
    <form action="/profile/edit" method="post" class="card">
        <label for="company-name">Company Name</label>
        <input type="text" id="company-name" name="company_name" required>
        
        <label for="company-location">Location</label>
        <input type="text" id="company-location" name="location" required>

        <label for="company-about">About</label>
        <input type="text" id="company-about" name="about" rows="3" required>

        <button type="submit" class="primary-btn">Confirm</button>
    </form>
</div>


<script src="/public/scripts/profile-edit.js"></script>