document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab");
  const contents = document.querySelectorAll(".tab-content");
  const form = document.getElementById("signupForm");
  const roleInput = document.getElementById("role");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm-password");
  const confirmPasswordErrMsg = document.getElementById(
    "confirm-password-errmsg"
  );
  const passwordErrMsg = document.getElementById("password-errmsg");
  const email = document.getElementById("email");

  function setRequiredFields(tabId) {
    const jobseekerFields = form.querySelectorAll("#jobseekerContent input");
    const companyFields = form.querySelectorAll(
      "#companyContent input, #companyContent textarea"
    );

    if (tabId === "jobseeker") {
      jobseekerFields.forEach((field) => (field.required = true));
      companyFields.forEach((field) => (field.required = false));
    } else {
      jobseekerFields.forEach((field) => (field.required = false));
      companyFields.forEach((field) => (field.required = true));
    }
  }

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const tabId = tab.getAttribute("data-tab");

      tabs.forEach((t) => t.classList.remove("active"));
      contents.forEach((c) => c.classList.remove("active"));

      tab.classList.add("active");
      document.getElementById(tabId + "Content").classList.add("active");

      roleInput.value = tabId;

      setRequiredFields(tabId);
    });
  });

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    if (validatePasswords()) {
      this.submit();
    }
  });

  function validatePasswords() {
    let isValid = true;
    confirmPasswordErrMsg.textContent = "";
    passwordErrMsg.textContent = "";

    if (password.value !== confirmPassword.value) {
      confirmPasswordErrMsg.textContent = "Passwords do not match";
      isValid = false;
    }

    if (password.value.length < 8) {
      passwordErrMsg.textContent = "Password must be at least 8 characters long";
      password.classList.add("redborder");
      isValid = false;
    } else {
      password.classList.remove("redborder");
    }

    return isValid;
  }

  setRequiredFields("jobseeker");
  password.addEventListener("input", validatePasswords);
  confirmPassword.addEventListener("input", validatePasswords);
});