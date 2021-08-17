<?php

checkLogin();
hideFromUsers();
get_header();

if(is_post_valid('2','usertacticsprogress')) echo "<br>1<br>";
if(is_post_valid('489','usertacticsprogress')) echo "<br>2<br>";
if(is_post_valid(489,'usertacticsprogress')) echo "<br>3<br>";
if(is_post_valid(102,'lessons')) echo "<br>4<br>";

$test_var_1 = 1;
$test_var_0 = 0;

if($test_var_0) echo "0 is true in php";
if($test_var_1) echo "1 is true in php";


get_footer();
