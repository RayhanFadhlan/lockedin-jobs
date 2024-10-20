document.addEventListener('DOMContentLoaded', function() {

    const mainImage = document.querySelector('.main-image');
    const url = window.location.href;
    const jobId = url.substring(url.lastIndexOf('/') + 1);

    const thumbnails = document.querySelectorAll('.thumbnail img');
    const deleteButtopn = document.getElementById('delete-button');
    const closeJobForm = document.getElementById('close-job-form');
    const closeButton = document.getElementById('close-button');


    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
      
            mainImage.src = thumbnail.src;
        });
    });

    deleteButtopn.addEventListener('click', function() {
        const confirmation = confirm('Are you sure you want to delete this Job?');

        if(confirmation){
            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', `/company/job`, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');



            xhr.onreadystatechange = function() {
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                    const response = JSON.parse(xhr.responseText);
                    if(response.success){
                        window.location.href = '/company';
                        showToast("Job listing deleted successfully.");
                    } else {
                        console.error(response.message);
                        showToast(response.message);
                    }
                } else if(xhr.readyState === XMLHttpRequest.DONE){
                    showToast('Error deleting job listing.');
                }
            };
            xhr.send(JSON.stringify({lowongan_id: jobId}));
        }

    });

    
    closeButton.addEventListener('click', function(e) {


        // get the id from the url, http://localhost:8000/company/job/6
        const url = window.location.href;
        const jobId = url.substring(url.lastIndexOf('/') + 1);

        const xhr = new XMLHttpRequest();
        xhr.open('PATCH' ,`/company/job/changeopen`, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function() {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                const response = JSON.parse(xhr.responseText);
                if(response.success){
                    window.location.href = `/company/job/${jobId}`;
                    showToast(response.message);
                } else {
                    console.error(response.message);
                    showToast(response.message);
                }
            } else if(xhr.readyState === XMLHttpRequest.DONE){
                showToast('Error closing job listing.');
            }
        };
        xhr.send(JSON.stringify({lowongan_id: jobId}));

    
    });
    

});