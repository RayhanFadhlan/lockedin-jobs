function handleFileUpload(inputId, uploadBtnId, infoId, fileNameId, deleteBtnId) {
    const fileInput = document.getElementById(inputId);
    const uploadBtn = document.getElementById(uploadBtnId);
    const fileInfo = document.getElementById(infoId);
    const fileNameSpan = document.getElementById(fileNameId);
    const deleteButton = document.getElementById(deleteBtnId);

    fileInput.addEventListener('change', function (e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '';
        if (fileName) {
            uploadBtn.classList.add('hidden');
            fileInfo.classList.remove('hidden');
            fileNameSpan.textContent = fileName;
        }
    });

    deleteButton.addEventListener('click', function () {
        fileInput.value = '';
        uploadBtn.classList.remove('hidden');
        fileInfo.classList.add('hidden');
        fileNameSpan.textContent = '';
    });
}

handleFileUpload('pdf-file', 'pdf-upload-btn', 'pdf-file-info', 'pdf-file-name', 'pdf-delete-btn');
handleFileUpload('video-file', 'video-upload-btn', 'video-file-info', 'video-file-name', 'video-delete-btn');

document.getElementById('application-form').addEventListener('submit', function (e) {
    let isValid = true;
    const email = document.getElementById('email');
    const cvFile = document.getElementById('pdf-file');
    const videoFile = document.getElementById('video-file');

    if (email.value === '' || !email.value.includes('@')) {
        document.getElementById('email-error').textContent = 'Please enter a valid email address';
        isValid = false;
    } else {
        document.getElementById('email-error').textContent = '';
    }

    if (cvFile.files.length === 0) {
        document.getElementById('pdf-error').textContent = 'Please upload a PDF file';
        isValid = false;
    } else if (!cvFile.files[0].name.toLowerCase().endsWith('.pdf')) {
        document.getElementById('pdf-error').textContent = 'Please upload a valid PDF file';
        isValid = false;
    } else {
        document.getElementById('pdf-error').textContent = '';
    }

    if (videoFile.files.length > 0 && !videoFile.files[0].type.startsWith('video/')) {
        document.getElementById('video-error').textContent = 'Please upload a valid video file';
        isValid = false;
    } else {
        document.getElementById('video-error').textContent = '';
    }

    if (!isValid) {
        e.preventDefault(); 
    }
});
