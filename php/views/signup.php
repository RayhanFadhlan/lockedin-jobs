<div class="container">
        <div class="form-box">

            <h2>Make the most of your professional life</h2>
            
            <div class="tabs">
                <div class="tab active" data-tab="jobseeker">Job Seeker</div>
                <div class="tab" data-tab="company">Company</div>
            </div>

            <form id="signupForm" method="POST" action="/signup">
                <input type="hidden" id="role" name="role" value="jobseeker">
                
                <div id="jobseekerContent" class="tab-content active">
                    <label for="jobseeker-name">Name</label>
                    <input type="text" id="jobseeker-name" name="name" required>
                    
                    <label for="jobseeker-email">Email</label>
                    <input type="email" id="jobseeker-email" name="email" required>
                </div>
                
                <div id="companyContent" class="tab-content">
                    <label for="company-name">Company Name</label>
                    <input type="text" id="company-name" name="company_name" required>
                    
                    <label for="company-email">Company Email</label>
                    <input type="email" id="company-email" name="company_email" required>
                    
                    <label for="company-location">Location</label>
                    <input type="text" id="company-location" name="location" required>
                    
                    <label for="company-about">About</label>
                    <textarea id="company-about" name="about" rows="3" required></textarea>
                </div>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span id="password-errmsg" class="errmsg"></span>
                
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password"  required>
                <span id="confirm-password-errmsg" class="errmsg"></span>
                
                <button type="submit" class="primary-btn">Agree & Join</button>
            </form>

            <p class="box-link">Already on Lockedin? <a href="/login">Sign in</a></p>
        </div>
    </div>
<script src="/public/scripts/signup.js" defer></script>