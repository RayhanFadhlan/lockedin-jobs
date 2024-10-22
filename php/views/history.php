<div class="container">
    <div class="top-bar">
        <div class="search-box">
            <input type="text" placeholder="Cari Riwayat Lamaran" class="search-input">
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
            <div class="filter-by">
                <div class="dropdown">
                    <button class="dropdown-btn" data-dropdown-id="status">Status Lamaran</button>
                    <div class="dropdown-content">
                        <label><input type="checkbox" value="accepted"> Accepted</label>
                        <label><input type="checkbox" value="rejected"> Rejected</label>
                        <label><input type="checkbox" value="waiting"> Waiting</label>
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
</div>

<script src="/public/scripts/history.js"></script>