<link rel="stylesheet" href="/public/styles/company/create-job.css">
<div class="main-container">
    <div class="job-form-box">
        <h1 class="form-title">Edit a Job Posting</h1>
        <form id="jobEditForm">
            <div class="form-group">
                <label for="jobPosition">Job Position</label>
                <input type="text" id="jobPosition" name="jobPosition" value="<?= htmlspecialchars($jobPosition) ?>" required>
            </div>
           
            <div class="form-group">
                <label for="jobType">Job Type</label>
                <select id="jobType" name="jobType" required>
                    <option value="">Select job type</option>
                    <option value="Internship" <?= $jobType == 'Internship' ? 'selected' : '' ?>>Internship</option>
                    <option value="Part-time" <?= $jobType == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                    <option value="Full-time" <?= $jobType == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jobLocation">Job Location</label>
                <select id="jobLocation" name="jobLocation" required>
                    <option value="">Select job location</option>
                    <option value="On-site" <?= $jobLocation == 'On-site' ? 'selected' : '' ?>>Onsite</option>
                    <option value="Hybrid" <?= $jobLocation == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                    <option value="Remote" <?= $jobLocation == 'Remote' ? 'selected' : '' ?>>Remote</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jobDescription">Job Description</label>
                <div id="editor" class="quill-editor"><?= $jobDescription?></div>
            </div>
            <div class="form-group">
                <label for="attachment">Attachment(s)</label>
                <div class="file-input-container">
                    <input type="file" multiple="true" id="attachment" name="attachment" accept=".png,.jpg,.jpeg" class="file-input">
                    
                    <label for="attachment" class="file-label">Choose Image</label>
                </div>
            </div>
            <input type="submit" class="primary-btn"value="Edit Job">
        </form>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="/public/scripts/company/edit-job.js" defer></script>

