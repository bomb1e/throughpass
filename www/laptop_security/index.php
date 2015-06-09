<?php
session_start();
include("connection.php");
$link = Connection();

if(isset($_GET["cardID"])){
    $_SESSION["cardID"] = $_GET["cardID"];
    $cardID = $_GET["cardID"];
$user_data_sql = "SELECT Employee_id, First_name, Surname, User_image, Laptop_image, Laptop_serial, Other_details, Phone_no
                    from user_details WHERE user_details.Laptop_tag = '$cardID'";
if (mysqli_num_rows(mysqli_query($link,$user_data_sql))>0) {
$user_data = mysqli_fetch_object(mysqli_query($link,$user_data_sql));
$Employee_id = $user_data->Employee_id;
$First_name = $user_data->First_name;
$Surname = $user_data->Surname;
$User_image = $user_data->User_image;
$Laptop_image = $user_data->Laptop_image;
$Laptop_serial = $user_data->Laptop_serial;
$Other_details = $user_data->Other_details;
$Phone_no = $user_data->Phone_no;

?>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=no; width=device-width" />
        <link rel="stylesheet" href="assets/css/styles.css" type="text/css" />
    </head>
    <body>
        
        <div class="content ">
            <div class="leftColumn">
            
                <div class="card fixed-width">
                    <div class="card-image">
                        <img align="middle" src="data:image/jpeg;base64,<?php echo base64_encode($User_image); ?> ">
                        <h2><?php echo $First_name." ".$Surname; ?></h2>
                    </div>
                    <p><label>Role: </label><?php echo $Other_details;?></p>
                    <p><label>Employee ID: </label><?php echo $Employee_id;?></p>
                    <p><label>Laptop Serial No.: </label><?php echo $Laptop_serial;?></p>
                    <p><label>Contact Number: </label><?php echo $Phone_no;?></p>
                </div>      
            </div>
            <div class="rightColumn">
                <div class="card fixed-width">
                    <div class="card-image">
                    <img align="middle" src="data:image/jpeg;base64,<?php echo base64_encode($Laptop_image); ?> ">
                    <H1>Laptop Serial Number:
                    <?php echo $Laptop_serial;?></H1>
                    </div>
                </div> 
                <form action="http://192.168.0.5">
            <input class="btn" type="submit" value="Check New Laptop">
        </form> 
            </div>
         
        </div>
        
        
        <div class="header">
            Security Point Authentication for Laptops
        </div>
    </body>
</html>
<?php 
}
elseif (mysqli_num_rows(mysqli_query($link,$user_data_sql))==0) {
?>
<html>
<head>
        <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=no; width=device-width" />
        <link rel="stylesheet" href="assets/css/styles.css" type="text/css" />
    </head>
    <body>
        <div class="header">
            Security Point Authentication for Laptops
        </div>
        <div class="content ">
                <div class="card fixed-width">
                    <H1>The Laptop Does <b>NOT</b> exist on this database</H1>
                </div>      
        </div> 
    </body>
</html>
<?php
};

}
elseif (!isset($_GET["cardID"])) {
    ?>
    <html>
<head>
        <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=no; width=device-width" />
        <link rel="stylesheet" href="assets/css/styles.css" type="text/css" />
    </head>
    <body>
        <div class="header">
            Security Point Authentication for Laptops
        </div>
        <div class="content ">
                <div class="card fixed-width">
                    <H1>Please Scan a Laptop to Continue...</H1>
                </div>      
        </div> 
    </body>
</html>
    <?php
    # code...
}
?>