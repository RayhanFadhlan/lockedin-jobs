<div class="container">
    <div class="form-box">
        <h2>Sign in to FindIn</h2>
        <form id="loginForm" method="POST" action="/login">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <span id="password-errmsg" class="errmsg"></span>
            
            <button type="submit" class="primary-btn">Sign In</button>
        </form>

        <p class="box-link">New to FindIn? <a href="/signup">Join now</a></p>
    </div>
</div>
<script src="/public/scripts/login.js" defer></script>