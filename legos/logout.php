<?php
//logout.php
//Nik Rubenstein -- 11-26-2014
// Logout form


echo "<div class = 'login'>";

// show user
echo "Logged In As: {$uInfo['name_f']} {$uInfo['name_l']}";
br();

formForm("{$htmlRoot}/proc/logout.php",'post');
formInput('logout','submit','Log Out','class = "logoutButton"');
formClose();
echo "</div>";
?>
