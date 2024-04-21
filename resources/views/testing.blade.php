<!DOCTYPE html>
<html lang="en">
<head>
    <title>Phaung Daw Oo International University</title>
    <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/config.js') }}"></script>
</head>
<body>
  <div>
    <textarea id="editor"></textarea>
  </div>
</body>

<script>
$(document).ready(function(){
    // Initialize CKEditor
    CKEDITOR.replace('#editor');
});
</script>
</html>