<?php
require 'connect.php';
$results = array('update' => 0, 'insert' => 0, 'delete' => 0);
$mail = @$_REQUEST['email'];
set_time_limit(0);
clear_tmp();
$tn = 1;


if ($_FILES['change_file']['type'] == "text/xml") $file = simplexml_load_file($_FILES['change_file']['tmp_name']);
else $file = explode(PHP_EOL, file_get_contents($_FILES['change_file']['tmp_name']));

foreach ($file as $user){
    if ($_FILES['change_file']['type'] == "text/xml") {
        $login = $user->login;
        $password = $user->password;
        if ($user->name) $name = $user->name;
        else $name = $user->login;
        if ($user->email) $email = $user->email;
        else $email = $user->login . "@mail.ru";
    }
    else{
        $array = array();
        $array = explode(';', $user);
        $login = $array[0];
        $password = $array[1];
        if ($array[2]) $name = $array[2];
        else $name = $array[0];
        if ($array[3]) $email = $array[3];
        else $email = $array[0] . "@mail.ru";
    }
    if ($login){
        if (select("select * from users where login like '$login'")){
            mysql_query("UPDATE users set password = '{$password}', name = '{$name}', email = '{$email}' where login like '{$login}'");
            $results['update']++;
            tmp_insert($login);
        }
        else{
            mysql_query("INSERT INTO users (login, password, name, email)" . " VALUES('{$login}', '{$password}', '{$name}', '{$email}');");
            $results['insert']++;
            tmp_insert($login);
        }
    }
}

$results['delete'] = delete_not_valid_users();

echo "<p>Insert: ".$results['insert']."</p>";
echo "<p>Update: ".$results['update']."</p>";
echo "<p>Delete: ".$results['delete']."</p>";

$send_mail = mail($mail, "REPORT", "Insert: ".$results['insert']."\nUpdate: ".$results['update']."\nDelete: ".$results['delete']);
if ($send_mail) echo "<p>Send to ".$mail."</p>";
else echo "<p>Error! email incorrect.</p>";


$sql = mysql_query("SELECT * FROM users;");
if($sql)
{
    echo "<table border=1>";
    echo "<tr><td>LOGIN</td><td>PASSWORD</td><td>NAME</td><td>EMAIL</td></tr>";
    while($data = mysql_fetch_array($sql))
    {
        echo "<tr><td>".$data['login']."&nbsp;</td><td>".$data['password']."</td><td>".$data['name']."&nbsp;</td><td>".$data['email']."&nbsp;</td></tr>";
    }
    echo "</table>";
}

function delete_not_valid_users(){
    mysql_query("delete from users where login not in (select * from tmp_users)");
    return mysql_affected_rows();
}
function select($sql){
    $result = mysql_query($sql);
    return mysql_num_rows($result);
}
function tmp_insert($login){
    mysql_query("INSERT INTO tmp_users (login) VALUES('{$login}');");
}
function clear_tmp(){
    mysql_query('TRUNCATE TABLE tmp_users');
}

?>

