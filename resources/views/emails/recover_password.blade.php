<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
</head>
<body>
<h1>Password Recovery</h1>
<p>Click the link below to reset your password:</p>
<a href="{{ url('/password/reset?token=' . $token) }}">Reset Password</a>
</body>
</html>
