<?php
include_once("config.php");   
session_start();
if($_SERVER["REQUEST_METHOD"] != "POST"){
    //No ajax requeest
    return 0;
}
if(!isset($_POST["function"]))
{
    return 0;
}
$output = array();
$output['error']=false;;
$output['message']='';
switch($_POST["function"]){
    case "hide_contact":
        hide_contact();
        break;
    case "admin_logout":
        admin_logout();
        break;
        case "admin_query":
        admin_query();
        break;
}
echo json_encode($output);
//functions
// prevent multiple version of contact form
function hide_contact(){
    if(!isset($_SESSION['active_contact_form']) || !isset($_POST['fuction']))
{
    return 0;
}
    $_SESSION['active_contact_form']=false;
}
//Invlidate user on LogOut
function admin_logout(){
    $_SESSION["Authonticated"]=false;
    unset($_SESSION['AdminName']);
    $_SESSION["loginAttemps"]=0;
    return 1;
}
// return searched values form DB
function admin_query(){
    global $output,$db_servername, $db_username, $db_password;
    // Create connection
    try {
        $conn = new PDO("mysql:host=$db_servername;dbname=mygreencard;charset=utf8", $db_username, $db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
            $output['error']=true;          
            $output['error'][]='Databsase Error,'.'Connection failed: ' . $e->getMessage();
    } 
    $sql=create_sql();
    try {
        $stmt = $conn->query($sql);
    } catch (PDOException $e) {
        $output['error']=true;        
        $output['error'][]='Databsase Error,'.'Connection failed: ' . $e->getMessage();
    }
    $number_of_rows=$stmt->rowCount();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output['error']=false;;
    $output['message']='نتیجه آخرین جستجوی شما با'.' '.$number_of_rows.' '.'رکورد در دیتابیس مطابقت دارد.';
    // $output['applicant']['firstName']='success';
    // $output['spouse']['firstName']='success';
    // $output['children'][0]['firstName']='success';
    $conn = null;
}
function test_input($data) {
    // $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  // create sql for qury based on inuputs
  function create_sql(){
         // Get input and put them in variables  
    $ApplicantID=(int)test_input($_POST['searchID']);
    $TrackingCode=test_input($_POST['searchTrackingCode']);
    $TransId=(int)test_input($_POST['searchTransID']);
    $FirstName_fa=test_input($_POST['searchFirstName']);
    $LastName_fa=test_input($_POST['searchLastName']);
    $sql="";
    if($ApplicantID){
        $sql=" ID=$ApplicantID";
    }
    if($TrackingCode){
        if($sql){ $sql.=" AND"; }
        $sql.=" TrackingCode='$TrackingCode'";
    }
    if($TransId){
        if($sql){ $sql.=" AND"; }        
        $sql.=" TransID=$TransId";
    }
    if($FirstName_fa){
        if($sql){ $sql.=" AND"; }        
        $sql.=" FirstName_fa='$FirstName_fa'";
    }
    if($LastName_fa){
        if($sql){ $sql.=" AND"; }        
        $sql.=" LastName_fa='$LastName_fa'";
    }
    if($sql){  // if no search field selected select all rows
        $sql="SELECT * FROM applicant WHERE ".$sql;
    } else{
        $sql="SELECT * FROM applicant";
    }
    return $sql;
  }

?>