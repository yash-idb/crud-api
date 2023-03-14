<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
  @csrf
    <div class="form-group mb-4">
         <div class="custom-file text-left">
         	<input type="file" name="file" class="custom-file-input" id="customFile">
         	<label class="custom-file-label" for="customFile">Choose file</label>
         </div>
   </div>
          <button class="btn btn-primary">Import data</button>
         <!--<a class="btn btn-success" href="{{ route('file-export') }}">Export data</a>-->
 </form>
</body>
</html>