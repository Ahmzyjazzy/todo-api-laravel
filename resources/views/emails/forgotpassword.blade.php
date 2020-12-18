<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome <?php echo explode("_", $user->username)[0]; ?>,</h1>
    <p>Thank you for signing up, click the button below to activate your account</p>
    <button><a href="https://predictcontest.com/account/activate/{{ $token }}">here</a></button>
</body>
</html>