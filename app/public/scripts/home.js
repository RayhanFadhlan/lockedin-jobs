document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const sortSelect = document.querySelector('#sort');
    const jobTypeCheckboxes = document.querySelectorAll('input[type="checkbox"][value="full time"], input[type="checkbox"][value="part time"], input[type="checkbox"][value="internship"]');
    const jobPlaceCheckboxes = document.querySelectorAll('input[type="checkbox"][value="on site"], input[type="checkbox"][value="remote"], input[type="checkbox"][value="hybrid"]');

    document.querySelectorAll('.dropdown-btn').forEach(button => {
        button.addEventListener('click', function() {
            const dropdownContent = this.nextElementSibling;
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });
    });

    function getFilterValues() {
        return {
            search: searchInput.value.trim(),  
            sort: sortSelect.value,  
            jobType: Array.from(jobTypeCheckboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value),  
            jobPlace: Array.from(jobPlaceCheckboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value)  
        };
    }

    function buildQueryString(filters) {
        const queryParams = new URLSearchParams();

        if (filters.search) queryParams.append('search', filters.search);  
        if (filters.sort) queryParams.append('sort', filters.sort);  
        if (filters.jobType.length > 0) queryParams.append('jobType', filters.jobType.join(',')); 
        if (filters.jobPlace.length > 0) queryParams.append('jobPlace', filters.jobPlace.join(','));  

        return queryParams.toString();
    }

    function fetchData() {
        const filters = getFilterValues();
        const queryString = buildQueryString(filters);
        const xhr = new XMLHttpRequest();

        xhr.open('GET', `/home?${queryString}`, true);  

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                const rightContent = document.querySelector('.right-content');
                rightContent.innerHTML = ''; 
                
                if (data.length > 0) {
                    data.forEach(job => {
                        const jobContainer = document.createElement('div');
                        jobContainer.classList.add('job-container');
                        jobContainer.innerHTML = `
                            <h3>${job.posisi}</h3>
                            <p>${job.deskripsi}</p>
                            <p>Location: ${job.jenis_lokasi}</p>
                            <p>Job Type: ${job.jenis_pekerjaan}</p>
                            <p>Posted on: ${job.created_at}</p>
                        `;
                        rightContent.appendChild(jobContainer);
                    });
                } else {
                    rightContent.innerHTML = '<p>No job listings found matching your criteria.</p>';
                }
            }
        };

        xhr.onerror = function() {
            console.error('Error fetching data');
        };

        xhr.send();
    }

    searchInput.addEventListener('input', fetchData);
    sortSelect.addEventListener('change', fetchData);
    jobTypeCheckboxes.forEach(checkbox => checkbox.addEventListener('change', fetchData));
    jobPlaceCheckboxes.forEach(checkbox => checkbox.addEventListener('change', fetchData));

    fetchData();
});
