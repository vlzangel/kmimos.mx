<?php
//error_reporting(E_ALL);

if(isset($_POST['result']))
{
//echo "<h1>".calculo()."</h1>";
$resultado=calculo();
$correo_admin=$_POST['adm_c'];
$correo_usuario=$_POST['userm_c'];
$firs_usuario=$_POST['userf_c'];
$last_usuario=$_POST['userl_c'];
$usua_usuario=$_POST['useru_c'];
require_once("data_.php");
require_once("class.phpmailer.php");
require_once("email1.php");
require_once("email2.php");

}



function calculo(){

if(!isset($_POST['pg05'])){ $pg05='x'; } else{ $pg05 = $_POST['pg05']; }
if(!isset($_POST['pg09'])){ $pg09='x'; } else{ $pg09 = $_POST['pg09']; }
if(!isset($_POST['pg14'])){ $pg14='x'; } else{ $pg14 = $_POST['pg14']; }   
if(!isset($_POST['pg15'])){ $pg15='x'; } else{ $pg15 = $_POST['pg15']; }   
if(!isset($_POST['pg16'])){ $pg16='x'; } else{ $pg16 = $_POST['pg16']; }   
if(!isset($_POST['pg18'])){ $pg18='x'; } else{ $pg18 = $_POST['pg18']; }   
if(!isset($_POST['pg20'])){ $pg20='x'; } else{ $pg20 = $_POST['pg20']; }   
if(!isset($_POST['pg21'])){ $pg21='x'; } else{ $pg21 = $_POST['pg21']; }   
if(!isset($_POST['pg26'])){ $pg26='x'; } else{ $pg26 = $_POST['pg26']; }   
if(!isset($_POST['pg27'])){ $pg27='x'; } else{ $pg27 = $_POST['pg27']; }   
if(!isset($_POST['pg29'])){ $pg29='x'; } else{ $pg29 = $_POST['pg29']; }   
   
	
$pg01 = $_POST['pg01']; $pg02 = $_POST['pg02']; $pg03 = $_POST['pg03']; $pg04 = $_POST['pg04'];
$pg06 = $_POST['pg06']; $pg07 = $_POST['pg07']; $pg08 = $_POST['pg08'];  $pg10 = $_POST['pg10']; 
$pg11 = $_POST['pg11']; $pg12 = $_POST['pg12']; $pg13 = $_POST['pg13'];  
$pg17 = $_POST['pg17']; $pg19 = $_POST['pg19']; 
$pg22 = $_POST['pg22']; $pg23 = $_POST['pg23']; $pg24 = $_POST['pg24']; $pg25 = $_POST['pg25']; 
$pg28 = $_POST['pg28']; $pg30 = $_POST['pg30']; 
$pg31 = $_POST['pg31']; $pg32 = $_POST['pg32']; $pg33 = $_POST['pg33']; $pg34 = $_POST['pg34']; $pg35 = $_POST['pg35']; 
$pg36 = $_POST['pg36']; $pg37 = $_POST['pg37']; $pg38 = $_POST['pg38']; $pg39 = $_POST['pg39']; $pg40 = $_POST['pg40']; 
$pg41 = $_POST['pg41'];


$total=0;

/* 1 */
if ($pg01=='a') {$total=$total+0; } 
if ($pg01=='b') {$total=$total+4; } 
if ($pg01=='c') {$total=$total+6; } 
if ($pg01=='d') {$total=$total+10;}
/**/

/* 2 */
if ($pg02=='a') {$total=$total+4; } 
if ($pg02=='b') {$total=$total+5; } 
if ($pg02=='c') {$total=$total+10; } 
/*  */

/* 3 */
if ($pg03=='a') {$total=$total+4; } 
if ($pg03=='b') {$total=$total+10; } 
if ($pg03=='c') {$total=$total+0; } 
/**/

/* 4 */
if ($pg04=='a') {$total=$total+3; } 
if ($pg04=='b') {$total=$total+0; } 
if ($pg04=='c') {$total=$total+0; } 
if ($pg04=='d') {$total=$total+20;}
/* */

/* 5 */
if ($pg05=='a') {$total=$total+0; } 
if ($pg05=='b') {$total=$total+3; } 
if ($pg05=='c') {$total=$total+8; } 
if ($pg05=='d') {$total=$total+10;}
if ($pg05=='x') {$total=$total+0;}
/**/

/* 6 */
if ($pg06=='a') {$total=$total+8; } 
if ($pg06=='b') {$total=$total+10; } 
if ($pg06=='c') {$total=$total+0; } 
/**/

/* 7 */
if ($pg07=='a') {$total=$total+9; } 
if ($pg07=='b') {$total=$total+10; } 
if ($pg07=='c') {$total=$total+0; } 
if ($pg07=='d') {$total=$total+10;}
/**/

/* 8 */
if ($pg08=='a') {$total=$total+5; } 
if ($pg08=='b') {$total=$total+20; } 
/**/

/* 9 */
if ($pg09=='a') {$total=$total+8; } 
if ($pg09=='b') {$total=$total+5; } 
if ($pg09=='c') {$total=$total+0; } 
if ($pg09=='x') {$total=$total+0;}
/**/

/* 10 */
if ($pg10=='a') {$total=$total+9; } 
if ($pg10=='b') {$total=$total+10; } 
if ($pg10=='c') {$total=$total+0; } 
/**/

/* 11 */
if ($pg11=='a') {$total=$total+10; } 
if ($pg11=='b') {$total=$total+10; } 
if ($pg11=='c') {$total=$total+10; } 
/**/

/* 12 */
if ($pg12=='a') {$total=$total+5; } 
if ($pg12=='b') {$total=$total+7; } 
if ($pg12=='c') {$total=$total+10; } 
/**/

/* 13 */
if ($pg13=='a') {$total=$total+10; } 
if ($pg13=='b') {$total=$total+10; } 
/**/

/* 14 */
if ($pg14=='a') {$total=$total+9; } 
if ($pg14=='b') {$total=$total+10; } 
if ($pg14=='c') {$total=$total+6; } 
if ($pg14=='x') {$total=$total+0;}
/**/

/* 15 */
if ($pg15=='a') {$total=$total+10; } 
if ($pg15=='b') {$total=$total+10; } 
if ($pg15=='c') {$total=$total+10; } 
if ($pg15=='x') {$total=$total+0;}
/**/

/* 16 */
if ($pg16=='a') {$total=$total+8; } 
if ($pg16=='b') {$total=$total+9; } 
if ($pg16=='c') {$total=$total+10; }
if ($pg16=='x') {$total=$total+0;} 
/**/

/* 17 */
if ($pg17=='a') {$total=$total+10; } 
if ($pg17=='b') {$total=$total+10; } 
/**/

/* 18 */
if ($pg18=='a') {$total=$total+8; } 
if ($pg18=='b') {$total=$total+10; } 
if ($pg18=='c') {$total=$total+10; } 
if ($pg18=='x') {$total=$total+0;} 
/**/

/* 19 */
if ($pg19=='a') {$total=$total+10; } 
if ($pg19=='b') {$total=$total+10; } 
/**/

/* 20 */
if ($pg20=='a') {$total=$total+6; } 
if ($pg20=='b') {$total=$total+8; } 
if ($pg20=='c') {$total=$total+10; } 
if ($pg20=='x') {$total=$total+0;} 
/**/

/* 21 */
if ($pg21=='a') {$total=$total+5; } 
if ($pg21=='b') {$total=$total+5; } 
if ($pg21=='c') {$total=$total+10; } 
if ($pg21=='x') {$total=$total+0;} 
/**/

/* 22 */
if ($pg22=='a') {$total=$total+10; } 
if ($pg22=='b') {$total=$total+0; } 
/**/

/* 23 */
if ($pg23=='a') {$total=$total+8; } 
if ($pg23=='b') {$total=$total+10; } 
if ($pg23=='c') {$total=$total+0; } 
/**/

/* 24 */
if ($pg24=='a') {$total=$total+10; } 
if ($pg24=='b') {$total=$total+0; } 
/**/

/* 25 */
if ($pg25=='a') {$total=$total+10; } 
if ($pg25=='b') {$total=$total+10; } 
/**/

/* 26 */
if ($pg26=='a') {$total=$total+2; } 
if ($pg26=='b') {$total=$total+0; } 
if ($pg26=='c') {$total=$total+5; } 
if ($pg26=='x') {$total=$total+0;} 
/**/

/* 27 */
if ($pg27=='a') {$total=$total+3; } 
if ($pg27=='b') {$total=$total+10; } 
if ($pg27=='c') {$total=$total+0; } 
if ($pg27=='x') {$total=$total+0;} 
/**/

/* 28 */
if ($pg28=='a') {$total=$total+10; } 
if ($pg28=='b') {$total=$total+5; } 
/**/

/* 29 */
if ($pg29=='a') {$total=$total+10; } 
if ($pg29=='b') {$total=$total+8; } 
if ($pg29=='c') {$total=$total+0; }
if ($pg29=='x') {$total=$total+0;}  
/**/

/* 30 */
if ($pg11=='a') {$total=$total+10; } 
if ($pg11=='b') {$total=$total+8; } 
if ($pg11=='c') {$total=$total+0; } 
/**/

/* 31 */
if ($pg31=='a') {$total=$total+10; } 
if ($pg31=='b') {$total=$total+5; } 
/**/

/* 32 */
if ($pg32=='a') {$total=$total+10; } 
if ($pg32=='b') {$total=$total+5; } 
/**/

/* 33 */
if ($pg33=='a') {$total=$total+10; } 
if ($pg33=='b') {$total=$total+5; } 
/**/

/* 34 */
if ($pg34=='a') {$total=$total+10; } 
if ($pg34=='b') {$total=$total+0; } 
/**/

/* 35 */
if ($pg35=='a') {$total=$total+0; } 
if ($pg35=='b') {$total=$total+5; } 
if ($pg35=='c') {$total=$total+10; } 
/**/

/* 36 */
if ($pg36=='a') {$total=$total+5; } 
if ($pg36=='b') {$total=$total+3; } 
if ($pg36=='c') {$total=$total+10; } 
/**/

/* 37 */
if ($pg37=='a') {$total=$total+10; } 
if ($pg37=='b') {$total=$total+5; } 
if ($pg37=='c') {$total=$total+7; } 
/**/

/* 38 */
if ($pg38=='a') {$total=$total+10; } 
if ($pg38=='b') {$total=$total+5; }
/**/

/* 39 */
if ($pg39=='a') {$total=$total+10; } 
if ($pg39=='b') {$total=$total+5; } 
if ($pg39=='c') {$total=$total+1; } 
/**/

/* 40 */
if ($pg40=='a') {$total=$total+10; } 
if ($pg40=='b') {$total=$total+5; } 
if ($pg40=='c') {$total=$total+1; } 
/**/

/* 41 */
if ($pg41=='a') {$total=$total+0; } 
if ($pg41=='b') {$total=$total+10; }
/**/


return $total;

}//fin funcion
?>