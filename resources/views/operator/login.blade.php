<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <label for="username">Username:</label><br>
        <input type="username" id="username" name="username" required="required"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required="required"><br>
        <br>
        <input type="submit" value="Login">
    </form>
</body>

</html>
