<div class="container">
    <div class="form-container">
        <h1> Apply to <?= htmlspecialchars($data['posisi'])  ?></h1>
        <form id="application-form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="email-error"></div>
            </div>

            <div class="form-group">
            <label for="pdf-file">Attach PDF Resume</label>
            <div class="file-display" id="pdf-file-display">
                <label for="pdf-file" class="file-label" id="pdf-upload-btn">Upload PDF</label>
                <input type="file" id="pdf-file" name="pdf-file" class="file-input" accept=".pdf">
                <div class="file-info hidden" id="pdf-file-info">
                    <span class="file-name" id="pdf-file-name"></span>
                    <button type="button" class="delete-btn" id="pdf-delete-btn">x</button>
                </div>
            </div>
            <div class="error" id="pdf-error"></div>
        </div>

        <div class="form-group">
            <label for="video-file">Attach Video Introduction</label>
            <div class="file-display" id="video-file-display">
                <label for="video-file" class="file-label" id="video-upload-btn">Upload Video</label>
                <input type="file" id="video-file" name="video-file" class="file-input" accept="video/*">
                <div class="file-info hidden" id="video-file-info">
                    <span class="file-name" id="video-file-name"></span>
                    <button type="button" class="delete-btn" id="video-delete-btn">x</button>
                </div>
            </div>
            <div class="error" id="video-error"></div>
        </div>

        <button type="submit" class="submit-button">Submit application</button>
    </form>
</div>

<script src="/public/scripts/lamaran.js"></script>