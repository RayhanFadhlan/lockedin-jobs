const fileInput = document.getElementById('attachment');
const fileLabel = document.querySelector('.file-label');
const fileInputContainer = document.querySelector('.file-input-container');


let selectedFiles = [];


fileInput.addEventListener('change', handleFileSelect);

function handleFileSelect(event) {

    const files = event.target.files;
    

    selectedFiles = [];
    
   
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (validateFile(file)) {
            selectedFiles.push(file);
        } else {
            console.warn(`File ${file.name} is not a valid image file.`);
        }
    }
    
    
    updateFileList();
}

function validateFile(file) {
    
    const acceptedTypes = ['.png', '.jpg', '.jpeg'];
    const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
    return acceptedTypes.includes(fileExtension);
}

function updateFileList() {
    
    const existingList = fileInputContainer.querySelector('.file-list');
    if (existingList) {
        existingList.remove();
    }
    
   
    if (selectedFiles.length > 0) {
        const fileList = document.createElement('ul');
        fileList.className = 'file-list';
        
        selectedFiles.forEach(file => {
            const listItem = document.createElement('li');
            listItem.textContent = file.name;
            fileList.appendChild(listItem);
        });
        
        fileInputContainer.appendChild(fileList);
        fileLabel.textContent = `${selectedFiles.length} file(s) selected`;
    } else {
        fileLabel.textContent = 'Choose Image';
    }
}


function getSelectedFiles() {
    return selectedFiles;
}