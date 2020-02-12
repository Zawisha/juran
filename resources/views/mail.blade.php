<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Активация регистрации нового пользователя</title>
</head>
<body>
<h1>Спасибо за регистрацию! </h1>

<p>
    Перейдите <a href='{{ url("http://mart.juran.by/accept/{$token}") }}'>по ссылке </a>чтобы завершить регистрацию!
</p>
</body>
</html>
