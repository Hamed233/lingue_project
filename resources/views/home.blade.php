<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lingua Franca</title>
</head>
<body>
    <h1>Welcome {{userDetails('logged', 'name&id')['name']}}</h1>
    <h3><a href="/admincp">Control panel</a></h3>
    <h3><a href="/logout">Logout</a></h3>
</body>
</html>

