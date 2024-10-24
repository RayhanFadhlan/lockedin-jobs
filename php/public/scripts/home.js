document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".search-input");
  const sortSelect = document.querySelector("#sort");
  const jobTypeCheckboxes = document.querySelectorAll(
    'input[type="checkbox"][value="Full-time"], input[type="checkbox"][value="Part-time"], input[type="checkbox"][value="internship"]'
  );
  const jobPlaceCheckboxes = document.querySelectorAll(
    'input[type="checkbox"][value="On-site"], input[type="checkbox"][value="remote"], input[type="checkbox"][value="hybrid"]'
  );
  const rightContent = document.querySelector(".right-content");
  let currentPage = 1;
  let debounceTimer;

  function debounce(func, delay) {
    return function (...args) {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => func.apply(this, args), delay);
    };
  }

  function getFilterValues() {
    return {
      search: searchInput.value.trim(),
      sort: sortSelect.value,
      jobType: Array.from(jobTypeCheckboxes)
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.value),
      jobPlace: Array.from(jobPlaceCheckboxes)
        .filter((checkbox) => checkbox.checked)
        .map((checkbox) => checkbox.value),
      page: currentPage,
    };
  }

  function buildQueryString(filters) {
    const queryParams = new URLSearchParams();

    if (filters.search) queryParams.append("search", filters.search);
    if (filters.sort) queryParams.append("sort", filters.sort);
    if (filters.jobType.length > 0)
      queryParams.append("jobType", filters.jobType.join(","));
    if (filters.jobPlace.length > 0)
      queryParams.append("jobPlace", filters.jobPlace.join(","));
    queryParams.append("page", filters.page);

    return queryParams.toString();
  }

  function fetchData() {
    const filters = getFilterValues();
    const queryString = buildQueryString(filters);
    window.history.pushState({}, "", `?${queryString}`);
    const xhr = new XMLHttpRequest();

    xhr.open("GET", `/?${queryString}`, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        updateJobListings(response.jobs);
        updatePagination(response.currentPage, response.totalPages);
        updateTrendingJobs(response.trendingJobs);
      }
    };

    xhr.onerror = function () {
      console.error("Error fetching data");
    };

    xhr.send();
  }

  function updateTrendingJobs(trendingJobs) {
    const trendingContainer = document.getElementById("trending-jobs-list");
    trendingContainer.innerHTML = "";

    if (trendingJobs && trendingJobs.length > 0) {
      trendingJobs.forEach((job) => {
        const jobContainer = document.createElement("div");
        jobContainer.classList.add("trending-job-container");

        const date = new Date(job.created_at);
        const formattedDate = new Intl.DateTimeFormat("en-US", {
          dateStyle: "medium",
        }).format(date);

        jobContainer.innerHTML = `
                <div class="trending-job-item">
                    <div class="trending-job-details">
                        <h2>${job.posisi}</h2>
                        <p>Location: ${job.jenis_lokasi}</p>
                        <p>Job Type: ${job.jenis_pekerjaan}</p>
                        <p>Applicants: ${job.pelamar_count}</p>
                        <p>Posted on: ${formattedDate}</p>
                    </div>
                </div>
            `;

        jobContainer.addEventListener("click", function () {
          window.location.href = `/lowongan/${job.lowongan_id}`;
        });

        trendingContainer.appendChild(jobContainer);
      });
    } else {
      trendingContainer.innerHTML = "<h4>No trending jobs at the moment.</h4>";
    }
  }

  function updateJobListings(jobs) {
    rightContent.innerHTML = "";

    if (jobs.length > 0) {
      jobs.forEach((job) => {
        const jobContainer = document.createElement("div");
        jobContainer.classList.add("job-container");

        const date = new Date(job.created_at);
        const formattedDate = new Intl.DateTimeFormat("en-US", {
          dateStyle: "medium",
        }).format(date);

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
              <h3>${job.posisi}</h3>
              <p>Location: ${job.jenis_lokasi}</p>
              <p>Job Type: ${job.jenis_pekerjaan}</p>
              <p>Posted on: ${formattedDate}</p>
            </div>
          </div>
        `;

        jobContainer.addEventListener("click", function () {
          window.location.href = `/lowongan/${job.lowongan_id}`;
        });

        rightContent.appendChild(jobContainer);
      });
    } else {
      rightContent.innerHTML =
        "<p>No job listings found matching your criteria.</p>";
    }
  }

  function updatePagination(currentPage, totalPages) {
    const paginationContainer = document.createElement("div");
    paginationContainer.classList.add("pagination");

    const prevButton = createPaginationButton(
      "Previous",
      currentPage > 1 ? currentPage - 1 : null
    );
    paginationContainer.appendChild(prevButton);

    if (totalPages <= 5) {
      for (let i = 1; i <= totalPages; i++) {
        const pageButton = createPaginationButton(i, i);
        if (i === currentPage) {
          pageButton.classList.add("active");
        }
        paginationContainer.appendChild(pageButton);
      }
    } else {
      const firstPageButton = createPaginationButton(1, 1);
      if (1 === currentPage) {
        firstPageButton.classList.add("active");
      }
      paginationContainer.appendChild(firstPageButton);

      if (currentPage > 3) {
        const ellipsis = createPaginationEllipsis(1);
        paginationContainer.appendChild(ellipsis);
      }

      const startPage = Math.max(2, currentPage - 1);
      const endPage = Math.min(totalPages - 1, currentPage + 1);

      for (let i = startPage; i <= endPage; i++) {
        const pageButton = createPaginationButton(i, i);
        if (i === currentPage) {
          pageButton.classList.add("active");
        }
        paginationContainer.appendChild(pageButton);
      }

      if (currentPage < totalPages - 2) {
        const ellipsis = createPaginationEllipsis(totalPages);
        paginationContainer.appendChild(ellipsis);
      }

      const lastPageButton = createPaginationButton(totalPages, totalPages);
      if (totalPages === currentPage) {
        lastPageButton.classList.add("active");
      }
      paginationContainer.appendChild(lastPageButton);
    }

    const nextButton = createPaginationButton(
      "Next",
      currentPage < totalPages ? currentPage + 1 : null
    );
    paginationContainer.appendChild(nextButton);

    rightContent.appendChild(paginationContainer);
  }

  function createPaginationEllipsis(lastPage) {
    const ellipsis = document.createElement("button");
    ellipsis.textContent = "...";
    ellipsis.classList.add("pagination-button");
    ellipsis.addEventListener("click", () => {
      currentPage = lastPage;
      fetchData();
      window.scrollTo(0, 0);
    });
    return ellipsis;
  }

  function createPaginationButton(text, page) {
    const button = document.createElement("button");
    button.textContent = text;
    button.classList.add("pagination-button");
    if (page !== null) {
      button.addEventListener("click", () => {
        currentPage = page;
        fetchData();
        window.scrollTo(0, 0);
      });
    } else {
      button.disabled = true;
    }
    return button;
  }

  function setFiltersFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    searchInput.value = urlParams.get("search") || "";
    sortSelect.value = urlParams.get("sort") || "";
    jobTypeCheckboxes.forEach((checkbox) => {
      checkbox.checked = false;
      if (urlParams.has("jobType")) {
        const jobTypes = urlParams.get("jobType").split(",");
        if (jobTypes.includes(checkbox.value)) {
          checkbox.checked = true;
        }
      }
    });

    jobPlaceCheckboxes.forEach((checkbox) => {
      checkbox.checked = false;
      if (urlParams.has("jobPlace")) {
        const jobPlaces = urlParams.get("jobPlace").split(",");
        if (jobPlaces.includes(checkbox.value)) {
          checkbox.checked = true;
        }
      }
    });

    currentPage = parseInt(urlParams.get("page")) || 1;
  }

  setFiltersFromURL();
  fetchData();

  searchInput.addEventListener(
    "input",
    debounce(() => {
      currentPage = 1;
      fetchData();
    }, 500)
  );

  sortSelect.addEventListener("change", () => {
    currentPage = 1;
    fetchData();
  });
  jobTypeCheckboxes.forEach((checkbox) =>
    checkbox.addEventListener("change", () => {
      currentPage = 1;
      fetchData();
    })
  );
  jobPlaceCheckboxes.forEach((checkbox) =>
    checkbox.addEventListener("change", () => {
      currentPage = 1;
      fetchData();
    })
  );

  window.addEventListener("popstate", function (event) {
    setFiltersFromURL();
    fetchData();
  });
});
