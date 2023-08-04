import './bootstrap';

import.meta.glob([
    '../images/**'
]);

const dropArea = document.getElementById('drop-area');
const urlUpload = dropArea.dataset.urlUpload;
const X_CSRF_TOKEN = document.head.querySelector('meta[name="csrf-token"]').content;
const resultArea = document.getElementById('result-area');
const verificationResult = document.getElementById('verification-result');
const issuer = document.getElementById('issuer');

// Prevent default behaviors to enable drop
dropArea.addEventListener('dragenter', (e) => {
    e.preventDefault();
    dropArea.classList.add('active');
});

dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
});

dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('active');
});

dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('active');

    const files = e.dataTransfer.files;
    handleFiles(files);
});

const fileInput = document.getElementById('file');
fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    handleFiles(files);
});

function handleFiles(files) {
    const fileArray = Array.from(files);

    // Process the files (e.g., upload to a server, display previews, etc.)
    fileArray.forEach(file => {

        // Perform further operations here (e.g., upload using XHR, display previews, etc.)
        const xhr = new XMLHttpRequest();

        // Progress event listener to track the upload progress
        xhr.upload.addEventListener("progress", function (e) {
            //const progressDiv = document.getElementById("progress");
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                console.log(percentComplete);
                //progressDiv.innerHTML = `Upload progress: ${Math.round(percentComplete)}%`;
            }
        });

        // Upload complete event listener
        xhr.addEventListener("load", function (e) {
            if (xhr.status === 200) {

                const response = JSON.parse(xhr.responseText);
                // Handle the server response here if needed
                if (response['data']) {
                    resultArea.classList.remove('d-none');
                    verificationResult.innerHTML = response['data']['result'];
                    issuer.innerHTML = response['data']['issuer'];
                }else{
                    resultArea.classList.add('d-none');
                }

                fileInput.value = '';
            } else {
                console.error("Error occurred while uploading the file.");
            }
        });

        // Error event listener
        xhr.addEventListener("error", function (e) {
            console.error("Error occurred while uploading the file.");
        });

        // Prepare and send the request
        const formData = new FormData();
        formData.append("file", file);
        formData.append("_token", X_CSRF_TOKEN);
        xhr.open("POST", urlUpload, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send(formData);
    });
}
