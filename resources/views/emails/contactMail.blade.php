<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>New Contact Message from -<small color="text-danger">&nbsp;{{ $data['name'] }}</small></h1>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
    <p><strong>Country:</strong> {{ $data['country'] }}</p>
    <p><strong>Message:</strong> {{ $data['message'] }}</p>
</body>

</html>