<div class="container">
    <div class="job-form-box">
        <h1>Create a Job Posting</h1>
        <form id="jobPostingForm">
            <div class="form-group">
                <label for="jobPosition">Job Position</label>
                <input type="text" id="jobPosition" name="jobPosition" required>
            </div>
           
            <div class="form-group">
                <label for="jobType">Job Type</label>
                <select id="jobType" name="jobType" required>
                    <option value="">Select job type</option>
                    <option value="internship">Internship</option>
                    <option value="parttime">Part-time</option>
                    <option value="fulltime">Full-time</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jobLocation">Job Location</label>
                <select id="jobLocation" name="jobLocation" required>
                    <option value="">Select job location</option>
                    <option value="onsite">Onsite</option>
                    <option value="hybrid">Hybrid</option>
                    <option value="remote">Remote</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jobDescription">Job Description</label>
                <div id="editor" class="quill-editor"></div>
            </div>
            <div class="form-group">
                <label for="attachment">Attachment</label>
                <div class="file-input-container">
                    <input type="file" multiple="true" id="attachment" name="attachment" accept=".png,.jpg,.jpeg" class="file-input">
                    
                    <label for="attachment" class="file-label">Choose Image</label>
                </div>
            </div>
            <input type="submit" class="primary-btn"value="Post Job">
        </form>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="/public/scripts/create-job.js" defer></script>

<script>
  const quill = new Quill('#editor', {
    theme: 'snow'
  });
</script>