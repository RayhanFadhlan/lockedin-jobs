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
      }
    };

    xhr.onerror = function () {
      console.error("Error fetching data");
    };

    xhr.send();
  }

  function updateJobListings(jobs) {
    rightContent.innerHTML = "";

    if (jobs.length > 0) {
      jobs.forEach((job) => {
        const jobContainer = document.createElement("div");
        jobContainer.classList.add("job-container");
        jobContainer.innerHTML = `
                    <h3>${job.posisi}</h3>
                    <p>${job.deskripsi}</p>
                    <p>Location: ${job.jenis_lokasi}</p>
                    <p>Job Type: ${job.jenis_pekerjaan}</p>
                    <p>Posted on: ${job.created_at}</p>
                `;
        jobContainer.addEventListener("click", function () {
          window.location.href = `/detaillowongan/${job.lowongan_id}`;
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

    for (let i = 1; i <= totalPages; i++) {
      const pageButton = createPaginationButton(i, i);
      if (i === currentPage) {
        pageButton.classList.add("active");
      }
      paginationContainer.appendChild(pageButton);
    }

    const nextButton = createPaginationButton(
      "Next",
      currentPage < totalPages ? currentPage + 1 : null
    );
    paginationContainer.appendChild(nextButton);

    rightContent.appendChild(paginationContainer);
  }

  function createPaginationButton(text, page) {
    const button = document.createElement("button");
    button.textContent = text;
    button.classList.add("pagination-button");
    if (page !== null) {
      button.addEventListener("click", () => {
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
