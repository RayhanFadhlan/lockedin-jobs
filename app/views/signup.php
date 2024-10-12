<div class="signup-container">
    <div class="signup-box">
        <h2>Make the most of your professional life</h2>
        
       

        <form id="signupForm" method="POST" action="/signup">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Email" oninput="checkEmail()">
            <span id="email-errmsg" class="errmsg"></span>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required placeholder="Username" oninput="checkUsername()">
            <span id="username-errmsg" class="errmsg"></span>

            <label for="password">Password (8+ characters)</label>
            <input type="password" id="password" name="password" required placeholder="Password" oninput="checkPassword()">
            <span id="password-errmsg" class="errmsg"></span>

            <label for="role">Select Role</label>
            <select id="role" name="role" required onchange="checkRole()">
                <option value="">Select a role</option> 
                <option value="jobseeker">Jobseeker</option>
                <option value="company">Company</option>
            </select>
            <span id="role-errmsg" class="errmsg"></span>

            <button type="submit" id="signup-button" class="signup-btn">Agree & Join</button>
        </form>

        <p class="signin-link">Already on FindIn? <a href="/login">Sign in</a></p>
    </div>
</div>
<script src="/public/scripts/signup.js" defer></script>
