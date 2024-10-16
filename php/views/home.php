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

    <div class="left-content">
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
</div>


<script src="/public/scripts/home.js"></script>