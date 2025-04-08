<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module Content Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .module-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            position: relative;
        }
        .content-container {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <form action="{{route('modules.store')}}" method="POST" enctype="multipart/form-data">
            @csrf 
            <button type="button" class="btn btn-primary mb-3" id="addModule">Add Module +</button>
            <div id="modulesContainer"></div>
            <input type="submit" value="Save" class="btn btn-success">
            {{-- <button type="submit" class="btn btn-success">Save</button> --}}
            <button type="button" class="btn btn-danger">Cancel</button>
        </form>
    </div>

    <script>
        let moduleCount = 0;
        function addModule() {
            moduleCount++;
            let moduleDiv = document.createElement('div');
            moduleDiv.classList.add('module-container');
            moduleDiv.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm close-btn" onclick="this.parentElement.remove()">&times;</button>
                <h5>Module ${moduleCount}</h5>
                <input type="text" class="form-control mb-2" placeholder="Module Title">
                <button type="button" class="btn btn-primary mb-2" onclick="addContent(this)">Add Content +</button>
                <div class="contents"></div>
            `;
            document.getElementById('modulesContainer').appendChild(moduleDiv);
        }

        function addContent(button) {
            let contentDiv = document.createElement('div');
            contentDiv.classList.add('content-container');
            contentDiv.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm close-btn" onclick="this.parentElement.remove()">&times;</button>
                <h6>Content</h6>
                <input type="text" class="form-control mb-2" placeholder="Content Title">
                <input type="file" class="form-control mb-2">
                <input type="file" class="form-control mb-2">
            `;
            button.nextElementSibling.appendChild(contentDiv);
        }

        document.getElementById('addModule').addEventListener('click', addModule);
   


        document.getElementById('moduleForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData();
    
    document.querySelectorAll('.module-container').forEach((module, index) => {
        let moduleTitle = module.querySelector('input[type="text"]').value;
        formData.append(`modules[${index}][title]`, moduleTitle);

        module.querySelectorAll('.content-container').forEach((content, cIndex) => {
            let contentTitle = content.querySelector('input[type="text"]').value;
            formData.append(`modules[${index}][contents][${cIndex}][title]`, contentTitle);

            let files = content.querySelectorAll('input[type="file"]');
            files.forEach((fileInput, fIndex) => {
                if (fileInput.files[0]) {
                    formData.append(`modules[${index}][contents][${cIndex}][files][${fIndex}]`, fileInput.files[0]);
                }
            });
        });
    });

    fetch("{{ route('modules.store') }}", {
        method: "POST",
        body: formData,
        headers: { 
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.json();
    })
    .then(data => alert(data.message))
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred! Check the console for details.");
    });
});

        </script>
        
</body>
</html>
