<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Module Form</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<style>
		.module-container{
			background: #f8f8f8;
			padding: 15px;
			border-radius: 5px;
			margin-bottom: 20px;
			position: relative;
		}
		.content-container{
			background: #efefef;
			padding: 15px;
			border-radius: 5px;
			margin-bottom: 10px;
			position: relative;
		}
		.close-btn{
			position: absolute;
			top: 10px;
			right: 10px;
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				@if (Session('success'))
					<div class="alert alert-success">{{Session('success')}}</div>
				@endif
				<form action="{{route('module.store')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="mb-2">
						<a href="javascript:void(0)" class="btn btn-primary" id="addModule">Add Module +</a>
					</div>
					<div class="module-content">
						<!-- add code using js -->
					</div>
					<input type="submit" class="btn btn-success" value="Save">
					<input type="reset" class="btn btn-danger" value="Cancel">
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script>
		let moduleCount = 0;
		let addModuleBtn = document.getElementById('addModule');
		let moduleContent = document.querySelector('.module-content');

		addModuleBtn.addEventListener('click', function(){
			moduleCount++;
			let moduleDiv = document.createElement('div');
			moduleDiv.classList.add('module-container');
			moduleDiv.innerHTML = `
				<a href="javascript:void(0)" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm close-btn">&times;</a>
				<h5>Module ${moduleCount}</h5>
				<input type="text" name="moduleTitle[]" placeholder="Module Title" class="form-control mb-2">
				<a href="javascript:void(0)" onclick="addContent(this)" class="btn btn-primary">Add Content +</a>
				<div class="content mt-2"></div>
			`;

			moduleContent.appendChild(moduleDiv);
		});

		function addContent(button){
			let contentDiv = document.createElement('div');
			contentDiv.classList.add('content-container');
			contentDiv.innerHTML = `
				<a href="javascript:void(0)" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm close-btn">&times;</a>
				<h6>Content</h6>
				<input type="text" name="content[]" placeholder="Content Title" class="form-control mb-2">
				<input type="file" class="form-control mb-2" name="img1[]">
				<input type="file" class="form-control mb-2" name="img2[]">
			`;

			button.nextElementSibling.appendChild(contentDiv);
		}
	</script>
</body>
</html>