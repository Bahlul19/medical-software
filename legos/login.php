<?php
echo "<div class = 'login'>";
formForm("{$htmlRoot}/proc/login.php","post");
echo "<span>User Name: &nbsp;&nbsp;</span>";
formInput('uname','text'); //works
br();
echo "<span> Password: &nbsp;&nbsp;</span>";
formInput('pass','password'); //works
clearfix();
formInput('submit','submit','Log In','class = "loginButton"'); //works
formClose();
echo "</div>";
?>

