function uploadFile() {
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');

    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const fileName = file.name;

        // Display the uploaded file in the file list
        const listItem = document.createElement('div');
        listItem.innerHTML = `<p>${fileName}</p>`;
        fileList.appendChild(listItem);

        // TODO: Implement file upload logic here (server-side)
        // For simplicity, this example does not handle file uploads to a server.
    } else {
        alert('Please select a file to upload.');
    }
}
