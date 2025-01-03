document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const sortSelect = document.querySelector('#sort');
    const statusCheckboxes = document.querySelectorAll('input[type="checkbox"]');
    const rightContent = document.querySelector('.right-content');
    let currentPage = 1;
    let debounceTimer;

    function debounce(func, delay) {
      return function (...args) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(this, args), delay);
      };
    }

document.querySelectorAll('.dropdown-btn').forEach(button => {
    button.addEventListener('click', function() {
        const dropdownContent = this.nextElementSibling;
        dropdownContent.classList.toggle('open');

        const dropdownId = this.dataset.dropdownId;
        const isOpen = dropdownContent.classList.contains('open');
        localStorage.setItem(`dropdownState_${dropdownId}`, isOpen ? 'open' : 'closed');
    });
});

document.querySelectorAll('.dropdown-btn').forEach(button => {
    const dropdownContent = button.nextElementSibling;
    const dropdownId = button.dataset.dropdownId;
    const state = localStorage.getItem(`dropdownState_${dropdownId}`);

    if (state === 'open') {
        dropdownContent.classList.add('open');
    } else {
        dropdownContent.classList.remove('open');
    }
});


    function getFilterValues() {
        return {
            search: searchInput.value.trim(),
            sort: sortSelect.value,
            status: Array.from(statusCheckboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value),
            page: currentPage
        };
    }

    function buildQueryString(filters) {
        const queryParams = new URLSearchParams();

        if (filters.search) queryParams.append('search', filters.search);
        if (filters.sort) queryParams.append('sort', filters.sort);
        if (filters.status.length > 0) queryParams.append('status', filters.status.join(','));
        queryParams.append('page', filters.page);

        return queryParams.toString();
    }

    function fetchData() {
        const filters = getFilterValues();
        console.log(filters.status);
        const queryString = buildQueryString(filters);
        console.log(queryString);
        window.history.pushState({}, '', `?${queryString}`);
        const xhr = new XMLHttpRequest();

        xhr.open('GET', `/lamaran/datariwayat?${queryString}`, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                console.log(xhr.responseText);
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                updateLamaranList(response.lamaran);
                updatePagination(response.currentPage, response.totalPages);
            }
        };

        xhr.onerror = function() {
            console.error('Error fetching data');
        };

        xhr.send();
    }

    function updateLamaranList(lamaran) {
        rightContent.innerHTML = '';
        if (lamaran.length > 0) {
            lamaran.forEach(lamar => {
                const date = new Date(lamar.created_at);
                const options = {
                    month: 'long',  
                    day: 'numeric', 
                    year: 'numeric', 
                    hour: 'numeric', 
                    minute: 'numeric',
                    hour12: true    
                };
                
                const formattedDate = date.toLocaleString('en-US', options);

                const jobContainer = document.createElement('div');
                jobContainer.classList.add('job-container');
                jobContainer.innerHTML = `
                    <div class="job-item">
                        <div class="job-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" id="company-accent-4">
                            <path fill="#e7e2dc" d="M0 0h128v128H0z"/>
                            <path fill="#9db3c8" d="M48 16h64v112H48z"/>
                            <path fill="#788fa5" d="M16 80h32v48H16z"/>
                            <path fill="#56687a" d="M48 80h32v48H48z"/>
                        </svg>
                        </div>
                        <div class="job-details">
                        <h3>${lamar.nama}</h3>
                        <p>Position: ${lamar.posisi}</p>
                        <p>Submitted on: ${formattedDate}</p>
                        <p>Status: ${lamar.status}</p>
                        <a href="/lowongan/${lamar.lowongan_id}" class="button-lowongan">Detail Job Vacancy</a>
                        </div>
                    </div>
                `;
                rightContent.appendChild(jobContainer);
            });
        } else {
            rightContent.innerHTML = '<p>No job listings found matching your criteria.</p>';
        }
    }

    function updatePagination(currentPage, totalPages) {
        const paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination');

        const prevButton = createPaginationButton('Previous', currentPage > 1 ? currentPage - 1 : null);
        paginationContainer.appendChild(prevButton);

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = createPaginationButton(i, i);
            if (i === currentPage) {
                pageButton.classList.add('active');
            }
            paginationContainer.appendChild(pageButton);
        }

        const nextButton = createPaginationButton('Next', currentPage < totalPages ? currentPage + 1 : null);
        paginationContainer.appendChild(nextButton);

        rightContent.appendChild(paginationContainer);
    }

    function createPaginationButton(text, page) {
        const button = document.createElement('button');
        button.textContent = text;
        button.classList.add('pagination-button');
        if (page !== null) {
            button.addEventListener('click', () => {
                currentPage = page;
                fetchData();
            });
        } else {
            button.disabled = true;
        }
        return button;
    }

    function setFiltersFromURL() {
        const urlParams = new URLSearchParams(window.location.search);

        // Set the search input
        searchInput.value = urlParams.get('search') || '';

        // Set the sort select
        sortSelect.value = urlParams.get('sort') || '';

        // Reset and set status lamaran checkboxes
        statusCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            if (urlParams.has('status')) {
                const status = urlParams.get('status').split(',');
                if (status.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            }
        });

        // Set the current page
        currentPage = parseInt(urlParams.get('page')) || 1;
    }

    setFiltersFromURL();
    fetchData();

    // Event listeners
    searchInput.addEventListener('input', debounce(() => {
        currentPage = 1;
        fetchData();
    }, 500)
    );
    sortSelect.addEventListener('change', () => {
        currentPage = 1;
        fetchData();
    });
    statusCheckboxes.forEach(checkbox => checkbox.addEventListener('change', () => {
        currentPage = 1;
        fetchData();
    }));

    window.addEventListener('popstate', function(event) {
        setFiltersFromURL();
        fetchData();
    });

    
    fetchData();
});