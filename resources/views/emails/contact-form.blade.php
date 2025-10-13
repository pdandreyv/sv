<!DOCTYPE html>
<html>
<head>
    <title>Запрос из контактной формы</title>
</head>
 
<body>
<h1>Вам пришел запрос из контактной формы</h1>
<h2>Данные пользователя:</h2>
<p>Имя: {{$name}}</p>
<p>E-mail: {{$email}}</p>
<p>Телефон: {{$phone}}</p>
<p>Тема: {{$user_subject}}</p>
<p>Сообщение: {{$user_message}}</p>    	
<p>Папка: {{$filePath}}</p>    	
</body>
 
</html>