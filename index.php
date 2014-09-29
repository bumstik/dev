
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <title>dev</title>
</head> <body>
<form action="php/add_users.php" method="post" name="forma"  enctype="multipart/form-data">
    <fieldset>
        <label for="email">Send report to email:</label><br/>
        <input type="text" name="email" value="" size="30"><br/>
        <input type = "file" name = "change_file" size = "30"><br/>
    </fieldset>
    <br/>
    <fieldset>
        <input id="submit" type="submit" value="Load from DataBase"><br/>
    </fieldset>
</form>
</body>
</html>

