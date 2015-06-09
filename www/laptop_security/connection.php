<?php
function Connection(){
   if (!($link=mysqli_connect("localhost","root","","laptop_security")))  {
      exit();
   }

   return $link;
}
?>