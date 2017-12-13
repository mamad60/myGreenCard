<?php
include_once("config.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    //No ajax requeest
    return 0;
}
if (!isset($_POST["function"])) {
    return 0;
}
$output = array();
$output['error'] = false;;
$output['message'] = '';
switch ($_POST["function"]) {
    case "hide_contact":
        hide_contact();
        break;
    case "admin_logout":
        admin_logout();
        break;
    case "admin_query":
        admin_query();
        break;
    case "query_fetch":
        query_fetch();
        break;
    case "query_delete":
        query_delete();
        break;
    case "admin_register":
        admin_register();
        break;
}
echo json_encode($output);
//functions
// prevent multiple version of contact form
function hide_contact()
{
    if (!isset($_SESSION['active_contact_form']) || !isset($_POST['fuction'])) {
        return 0;
    }
    $_SESSION['active_contact_form'] = false;
}
//Invlidate user on LogOut
function admin_logout()
{
    $_SESSION["Authonticated"] = false;
    if (isset($_SESSION)) {
        session_destroy();
        unset($_SESSION);
    }
    return 1;
}
// return searched values form DB
function admin_query()
{
    global $output, $db_servername, $db_username, $db_password;
    // Create connection
    try {
        $conn = new PDO("mysql:host=$db_servername;dbname=mygreencard;charset=utf8", $db_username, $db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Databsase Error,' . 'Connection failed: ' . $e->getMessage();
    }
    $sql = create_sql();
    try {
        $stmt = $conn->query($sql);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Databsase Error,' . 'Connection failed: ' . $e->getMessage();
    }
    $number_of_rows = $stmt->rowCount();
    // Get all applicant matching the query
    $applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Select All Applicants matching the query
    //Iterate over ech applicatn and store spouse and children if exit
    $index = 0;
    foreach ($applicants as $applicant) {
        $records[$index]['applicant'] = $applicant;
        $applicantID = $applicant['ID'];
        if ($applicant['hasSpouse']) { // if applicant has spouse fill it
            $sql = "SELECT * FROM spouse WHERE ApplicantID=$applicantID";
            try {
                $stmt = $conn->query($sql);
            } catch (PDOException $e) {
                $output['error'] = true;
                $output['error'][] = 'Databsase Error,' . 'Query Failed: ' . $e->getMessage();
            }
            $spouse = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];  // Select All Applicants matching the query            
            $records[$index]['spouse'] = $spouse;
        } else {
            $records[$index]['spouse'] = null;
        }
        if ($applicant['hasChildren']) { // if applicant has spouse fill it
            $sql = "SELECT * FROM children WHERE ApplicantID=$applicantID";
            try {
                $stmt = $conn->query($sql);
            } catch (PDOException $e) {
                $output['error'] = true;
                $output['error'][] = 'Databsase Error,' . 'Query Failed: ' . $e->getMessage();
            }
            $children = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Select All Applicants matching the query            
            $records[$index]['children'] = $children;
        } else {
            $records[$index]['children'] = null;
        }
        $index++;
    }
    //put result to output
    $output['records'] = $records;
    $output['totalRows'] = $number_of_rows;
    //return message and error
    $output['error'] = false;;
    $output['message'] = 'نتیجه آخرین جستجوی شما با' . ' ' . $number_of_rows . ' ' . 'رکورد در دیتابیس مطابقت دارد.';
    $conn = null;
}
function query_fetch()
{
    $records = array();  // the record of results
    global $output, $db_servername, $db_username, $db_password;
    // Create connection
    try {
        $conn = new PDO("mysql:host=$db_servername;dbname=mygreencard;charset=utf8", $db_username, $db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Databsase Error,' . 'Connection failed: ' . $e->getMessage();
    }
    $sql = "SELECT * FROM applicant";
    try {
        $stmt = $conn->query($sql);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Databsase Error,' . 'Query Failed: ' . $e->getMessage();
    }
    $number_of_rows = $stmt->rowCount();
    // Get all applicant matching the query
    $applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Select All Applicants matching the query
    //Iterate over ech applicatn and store spouse and children if exit
    $index = 0;
    foreach ($applicants as $applicant) {
        $records[$index]['applicant'] = $applicant;
        $applicantID = $applicant['ID'];
        if ($applicant['hasSpouse']) { // if applicant has spouse fill it
            $sql = "SELECT * FROM spouse WHERE ApplicantID=$applicantID";
            try {
                $stmt = $conn->query($sql);
            } catch (PDOException $e) {
                $output['error'] = true;
                $output['error'][] = 'Databsase Error,' . 'Query Failed: ' . $e->getMessage();
            }
            $spouse = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];  // Select All Applicants matching the query            
            $records[$index]['spouse'] = $spouse;
        } else {
            $records[$index]['spouse'] = null;
        }
        if ($applicant['hasChildren']) { // if applicant has spouse fill it
            $sql = "SELECT * FROM children WHERE ApplicantID=$applicantID";
            try {
                $stmt = $conn->query($sql);
            } catch (PDOException $e) {
                $output['error'] = true;
                $output['error'][] = 'Databsase Error,' . 'Query Failed: ' . $e->getMessage();
            }
            $children = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Select All Applicants matching the query            
            $records[$index]['children'] = $children;
        } else {
            $records[$index]['children'] = null;
        }
        $index++;
    }
    //put result to output
    $output['records'] = $records;
    $output['totalRows'] = $number_of_rows;
    //return message and error
    $output['error'] = false;;
    $output['message'] = 'نتیجه آخرین جستجوی شما با' . ' ' . $number_of_rows . ' ' . 'رکورد در دیتابیس مطابقت دارد.';
    $conn = null;
}
function admin_register()
{
    global $output, $db_servername, $db_username, $db_password;
    if (isset($_POST['siteRegCode'])) {
        $siteRegCode = $_POST['siteRegCode'];
    }
    // Create connection
    try {
        $conn = new PDO("mysql:host=$db_servername;dbname=mygreencard;charset=utf8", $db_username, $db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Databsase Error,' . 'Connection failed: ' . $e->getMessage();
    }
    $sql = "UPDATE applicant SET siteRegCode = '$siteRegCode'  ,registerDate = '" . time() . "'  WHERE ID='" . $_POST['ID'] . "'";
    try {
        $stmt = $conn->query($sql);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Databsase Error,' . 'Record Registraiton Failed: ' . $e->getMessage();
    }
    // If spouse registration
    if (isset($_POST['spouseSiteRegCode'])) {
        $spouseSiteRegCode = $_POST['spouseSiteRegCode'];

        $sql = "UPDATE applicant SET spouseSiteRegCode ='$spouseSiteRegCode'  WHERE ID='" . $_POST['ID'] . "'";
        try {
            $stmt = $conn->query($sql);
        } catch (PDOException $e) {
            $output['error'] = true;
            $output['error'][] = 'Databsase Error,' . 'Record Registraiton Failed: ' . $e->getMessage();
        }
    }
    //If all thing goes well set registered to true
    if (!$output['error']) {
        $sql = "UPDATE applicant SET registered =true WHERE ID='" . $_POST['ID'] . "'";
        try {
            $stmt = $conn->query($sql);
        } catch (PDOException $e) {
            $output['error'] = true;
            $output['error'][] = 'Databsase Error,' . 'Record Registraiton Failed: ' . $e->getMessage();
        }
    }
    //return message and error
    $output['error'] = false;;
    $output['message'] = 'رکورد با آیدی $_Post["ID"]با موفقیت ثبت نام شد';
    $conn = null;
}
function query_delete()
{
    global $output, $db_servername, $db_username, $db_password;
    // Create connection
    try {
        $conn = new PDO("mysql:host=$db_servername;dbname=mygreencard;charset=utf8", $db_username, $db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Databsase Error,' . 'Connection failed: ' . $e->getMessage();
    }
    if (!isset($_POST["ID"])) {
        $output['error'] = true;
        $output['error'][] = 'No ID is send';
    }
    $ID = $_POST["ID"];
    $sql = "DELETE FROM applicant WHERE ID=$ID";
    try {
        $stmt = $conn->query($sql);
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'][] = 'Delete Operation Failed ' . $e->getMessage();
    }
    $number_of_rows = $stmt->rowCount();
    //put result to output
    $output['totalRows'] = $number_of_rows;
    //return message and error
    $output['error'] = false;;
    $output['message'] = 'تعداد ' . ' ' . $number_of_rows . ' ' . 'رکورد از دیتابیس حذف شد.';
    $conn = null;
}
function test_input($data)
{
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
  // create sql for qury based on inuputs
function create_sql()
{
         // Get input and put them in variables  
    $ApplicantID = (int)test_input($_POST['searchID']);
    $TrackingCode = test_input($_POST['searchTrackingCode']);
    $TransId = (int)test_input($_POST['searchTransID']);
    $FirstName_fa = test_input($_POST['searchFirstName']);
    $LastName_fa = test_input($_POST['searchLastName']);
    $sql = "";
    if ($ApplicantID) {
        $sql = " ID=$ApplicantID";
    }
    if ($TrackingCode) {
        if ($sql) {
            $sql .= " AND";
        }
        $sql .= " TrackingCode='$TrackingCode'";
    }
    if ($TransId) {
        if ($sql) {
            $sql .= " AND";
        }
        $sql .= " TransID=$TransId";
    }
    if ($FirstName_fa) {
        if ($sql) {
            $sql .= " AND";
        }
        $sql .= " FirstName_fa='$FirstName_fa'";
    }
    if ($LastName_fa) {
        if ($sql) {
            $sql .= " AND";
        }
        $sql .= " LastName_fa='$LastName_fa'";
    }
    if ($sql) {  // if no search field selected select all rows
        $sql = "SELECT * FROM applicant WHERE " . $sql;
    } else {
        $sql = "SELECT * FROM applicant";
    }
    return $sql;
}

?>