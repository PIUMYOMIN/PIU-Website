<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>404 Error - Page Not Found</title>
 <!-- Include Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
 <!-- Include Custom CSS -->
 <style>
 body {
  background-color: #f8f9fa;
 }

 .container {
  margin-top: 100px;
 }

 img {
  margin-bottom: 20px;
 }

 .btn-primary {
  background-color: #007bff;
  border-color: #007bff;
 }
 </style>
</head>

<body>
 <div class="container text-center mt-5">
  <img src="{{ asset('assets/img/errors.png') }}" alt="404 Error" class="img-fluid" width="300">
  <h1 class="mt-4">Oops! Page Not Found</h1>
  <p class="text-muted">The page you are looking for might have been removed or is temporarily unavailable.</p>
  <a href="{{ url('/') }}" class="btn btn-primary">Go to Homepage</a>
 </div>
</body>

</html>