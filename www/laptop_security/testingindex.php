<?php
session_start();
include("connection.php");
$link = Connection();

if(isset($_GET["cardID"])){
	$_SESSION["cardID"] = $_GET["cardID"];
	$cardID = $_GET["cardID"];
$user_data_sql = "SELECT Employee_id, First_name, Surname, User_image, Laptop_image, Laptop_serial, Other_details
					from user_details WHERE user_details.Laptop_tag = '$cardID'";
if (mysqli_num_rows(mysqli_query($link,$user_data_sql))>0) {
$user_data = mysqli_fetch_object(mysqli_query($link,$user_data_sql));
$Employee_id = $user_data->Employee_id;
$First_name = $user_data->First_name;
$Surname = $user_data->Surname;
$User_image = $user_data->User_image;
$Laptop_image = $user_data->Laptop_image;
$Laptop_serial = $user_data->Laptop_serial;
$Other_details = $user_data->Other_details
?>

<html>
<header></header>
<main>

	<div id = "user_pic" width="100px" height="100px">
		<img src="data:image/jpeg;base64,<?php echo base64_encode($User_image); ?> ">
	</div>
	<div id = "laptop_pic" width="190px" height="100px">
		<img src="data:image/jpeg;base64,<?php echo base64_encode($Laptop_image); ?>  ">
	</div>
	<div id = "user_details"><p><?php echo $Other_details; ?></p></div>

</main>
<footer></footer>
</html>

<?php 
}
elseif (mysqli_num_rows(mysqli_query($link,$user_data_sql))==0) {
?>
<html>
<header></header>
<main>
	<div id="errormsg"><p>Does Not Exist!</p></div>
	<div id="registration_link"></div>

</main>
<footer></footer>
</html>
<?php
};

}
elseif (!isset($_GET["cardID"])) {
	?>
	<html>
	<main><p>Please Scan Card....</p></main>
	</html>
	<?php
	# code...
}
?>