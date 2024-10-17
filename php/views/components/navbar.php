<nav class="navbar">
    <div class="navbar-container">
    <div class="navbar-left">
        <span class="logo"> <img src="../../public/images/logo.png"></span>
    </div>
    <div class="navbar-right">
        <a href="/" class="nav-item">
            <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
            </span>
            Home
        </a>
        <?php if (isset($_SESSION['user']['role'])): ?>
            <?php if ($_SESSION['user']['role'] === 'jobseeker'): ?>
                <a href="/history" class="nav-item"> 
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path d="M3 3v5h5"/>
                            <path d="M12 7v5l4 2"/>
                        </svg>
                    </span>
                    History
                </a>
            <?php elseif ($_SESSION['user']['role'] === 'company'): ?>
                <a href="/profile" class="nav-item"> 
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <path d="M20 8v6M23 11h-6"/>
                        </svg>
                    </span>
                    Sign Up
                </a>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['user']['role'])): ?>
            <?php if ($_SESSION['user']['role'] === 'jobseeker' || $_SESSION['user']['role'] === 'company'): ?>
                <div>
                    <a href="#" class="nav-link" id="profileDropdown">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/>
                            <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/>
                        </svg>
                    </span>
                        Me
                    </a>
                    <div class="dropdown-menu" id="profileDropdownMenu">
                        <a href="/profile" class="dropdown-item">View Profile</a>
                        <a href="/signout" class="dropdown-item">Sign Out</a>
                    </div>
                </div>
            <?php else: ?>
                <button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    </div>
</nav>