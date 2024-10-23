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
    </div>
    <div class="main-content">
        <div class="left-content">
            <div class="profile-card">
                <div class="profile-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" id="person-accent-4">
                        <path fill="#e7e2dc" d="M0 0h128v128H0z"/>
                        <path d="M88.41 84.67a32 32 0 10-48.82 0 66.13 66.13 0 0148.82 0z" fill="#788fa5"/>
                        <path d="M88.41 84.67a32 32 0 01-48.82 0A66.79 66.79 0 000 128h128a66.79 66.79 0 00-39.59-43.33z" fill="#9db3c8"/>
                        <path d="M64 96a31.93 31.93 0 0024.41-11.33 66.13 66.13 0 00-48.82 0A31.93 31.93 0 0064 96z" fill="#56687a"/>
                    </svg>
                </div>
                <div class="profile-info">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <h2 class="profile-name"><?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <?php else : ?>
                        <h2 class="profile-name">Guest</h2>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <p class="profile-title"><?= htmlspecialchars($_SESSION['user']['role'], ENT_QUOTES, 'UTF-8') ?></p>
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

            <div class="pagination">
                <button class="pagination-button" id="prev-page" disabled>&lt;</button>
                <div class="page-numbers">
                </div>
                <button class="pagination-button" id="next-page">&gt;</button>
            </div>
        </div>

        <div class="trending-jobs">
            <h3>Trending Jobs</h3>
            <div id="trending-jobs-list">
            </div>
        </div>
    </div>
</div>


<script src="/public/scripts/home.js"></script>