<div class="container">
    <div class="form-container">
        <h1> Apply to <?php echo "tes company"; ?></h1>
        <form id="application-form" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
                <div class="error" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="pdf-file">Attach PDF Resume</label>
                <div class="file-display" id="pdf-file-display">
                    <input type="file" id="pdf-file" name="pdf-file" class="file-input" accept=".pdf">
                    <label for="pdf-file" class="file-label" id="pdf-upload-btn">Upload PDF</label>
                </div>
                <div class="error" id="pdf-error"></div>
            </div>

            <div class="form-group">
                <label for="video-file">Attach Video Introduction</label>
                <div class="file-display" id="video-file-display">
                    <input type="file" id="video-file" name="video-file" class="file-input" accept="video/*">
                    <label for="video-file" class="file-label" id="video-upload-btn">Upload Video</label>
                </div>
                <div class="error" id="video-error"></div>
            </div>

            <button type="submit" class="submit-button">Submit application</button>
        </form>
    </div>
</div>

<script src="/public/scripts/lamaran.js"></script>