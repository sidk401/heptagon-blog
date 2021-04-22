<!DOCTYPE html>
<html>
<head>
    <title>Blog </title>
</head>
<body>
   Hi {{ ucfirst($details['user_name']) }},
   <br/>
<p>Title: <strong>{{ ucfirst($details['title']) }}</strong></p>

<p>Description: {{ $details['description'] }}</p>


<br/>
Blog Support Team
</body>
</html>