<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Admission Form Submitted</title>
</head>

<body>
    <h1>New Admission Form Submitted by <small
            color="text-danger">&nbsp;({{ htmlspecialchars($formData['name'], ENT_QUOTES) }})</small></h1>
    <p><strong>Email:</strong> {{ htmlspecialchars($formData['email'], ENT_QUOTES) }}</p>
    <p><strong>Phone:</strong> {{ htmlspecialchars($formData['phone'], ENT_QUOTES) }}</p>
    <p><strong>Country:</strong> {{ htmlspecialchars($formData['country'], ENT_QUOTES) }}</p>
    <p><strong>City:</strong> {{ htmlspecialchars($formData['city'], ENT_QUOTES) }}</p>
    <p><strong>Address:</strong> {{ htmlspecialchars($formData['address'], ENT_QUOTES) }}</p>
    <p><strong>National ID:</strong> {{ htmlspecialchars($formData['national_id'], ENT_QUOTES) }}</p>
    <p><strong>Zipcode:</strong> {{ htmlspecialchars($formData['zipcode'], ENT_QUOTES) }}</p>
    <p><strong>Gender:</strong> {{ htmlspecialchars($formData['gender'], ENT_QUOTES) }}</p>
    <p><strong>Marital Status:</strong> {{ htmlspecialchars($formData['marital_sts'], ENT_QUOTES) }}</p>
    <p><strong>New (or) Old student:</strong> {{ htmlspecialchars($formData['alumni_sts'], ENT_QUOTES) }}</p>
    <p><strong>Date Of Birth:</strong> {{ htmlspecialchars($formData['dob'], ENT_QUOTES) }}</p>
    <p><strong>Apply Course:</strong> {{ $formData['course']->name }}</p>
        <p>Click <a href="{{ $url }}">here</a> to view the admission forms.</p>
    </p>
</body>

</html>
