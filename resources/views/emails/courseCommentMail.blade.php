<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>New Course Comment Received from -<small color="text-danger">&nbsp;{{ $data['name'] }}</small></h1>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Message:</strong> {{ $data['message'] }}</p>
    <p>
      Course Link: <a href="{{ $courseLink }}">{{ $courseLink }}</a>
    </p>
</body>

</html>