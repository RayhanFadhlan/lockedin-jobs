<div class="container">
    <div class="left-content">
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

        <div class="filter-by">
            <div class="dropdown">
                <button class="dropdown-btn">Job Type</button>
                <div class="dropdown-content">
                    <label><input type="checkbox" value="full time"> Full Time</label>
                    <label><input type="checkbox" value="part time"> Part Time</label>
                    <label><input type="checkbox" value="internship"> Internship</label>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropdown-btn">Job Place</button>
                <div class="dropdown-content">
                    <label><input type="checkbox" value="on site"> On Site</label>
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