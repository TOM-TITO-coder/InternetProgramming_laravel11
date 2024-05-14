<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
</head>
<body>
    <h1>Upload Image</h1>
    <form action="/store" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <input type="text" name="title">
        <button type="submit">Upload</button>
        <a href="/gallery">cancel</a>
    </form>
</body>
</html>
