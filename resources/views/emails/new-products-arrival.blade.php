<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Hello!</p>
    <p>This is our daily email notification about 10 latest products added to the store.</p>
    @foreach ($products as $product)
        <p><strong>{{ $product->name }}</strong></p>
    @endforeach
</body>
</html>