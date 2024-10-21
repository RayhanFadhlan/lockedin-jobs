<div class="container">
    <div class="top-bar">
        <div class="search-box">
            <input type="text" placeholder="Search for jobs..." class="search-input">
        </div>

        <div class="sort-by">
            <label for="sort">Sort by Date:</label>
            <select id="sort" name="sort">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>

        <div class="add-job">
            <a href="/company/createjob" class="add-job-btn">Add New Job</a>
        </div>
    </div>
    <div class="main-content">
        <div class="left-content">
            <div class="profile-card">
                <div class="profile-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" id="company-accent-4">
                        <path fill="#e7e2dc" d="M0 0h128v128H0z"/>
                        <path fill="#9db3c8" d="M48 16h64v112H48z"/>
                        <path fill="#788fa5" d="M16 80h32v48H16z"/>
                        <path fill="#56687a" d="M48 80h32v48H48z"/>
                    </svg>
                </div>
                <div class="profile-info">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <h2 class="profile-name"><?= htmlspecialchars($_SESSION['user']['name']) ?></h2>
                    <?php else : ?>
                        <h2 class="profile-name">Guest</h2>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <p class="profile-title"><?= htmlspecialchars($_SESSION['user']['role']) ?></p>
                    <?php else : ?>
                        <p class="profile-title">No Role</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="filter-by">
                <div class="dropdown">
                    <button class="dropdown-btn" data-dropdown-id="jobType">Job Type</button>
                    <div class="dropdown-content">
                        <label><input type="checkbox" value="Full-time"> Full Time</label>
                        <label><input type="checkbox" value="Part-time"> Part Time</label>
                        <label><input type="checkbox" value="internship"> Internship</label>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="dropdown-btn" data-dropdown-id="jobPlace">Job Place</button>
                    <div class="dropdown-content">
                        <label><input type="checkbox" value="On-site"> On Site</label>
                        <label><input type="checkbox" value="remote"> Remote</label>
                        <label><input type="checkbox" value="hybrid"> Hybrid</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-content"> 
            <div class="job-listings hidden">

            </div>
            <div class="pagination">
                <button class="pagination-button" id="prev-page" disabled>&lt;</button>
                <div class="page-numbers">
                </div>
                <button class="pagination-button" id="next-page">&gt;</button>
            </div>
        </div>
    </div>
</div>


<script src="/public/scripts/home-company.js"></script>