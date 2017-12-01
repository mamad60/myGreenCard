<?php

function saveToDB(){   
    include_once("functions.php");
    $output['error']=[]; //Returned varibles to caller
    $output['TrackingCode']='';
    // Main Applicant Data
    if (isset($_SESSION['Applicant']) && !empty($_SESSION['Applicant'])) {
        $applicant=$_SESSION['Applicant'];    
        $hasChildren=strtolower($applicant['hasChildren'])=='true';
        $hasSpouse=strtolower($applicant['hasSpouse'])=='true';
        if (isset($_SESSION['Spouse'])){
            $spouse=$_SESSION['Spouse'];
        }
        if (isset($_SESSION['Children'])){
            $children=$_SESSION['Children'];
        }
        if (isset($_SESSION['Price'])){
            $price=$_SESSION['Price'];
        }
    }
    else {
        $output['error'][]='No Applicant data is sent';
        die('NO Applicant Data');
    }
    // Setup Connection to the MySQL database
    $servername = 'localhost';
    $username = 'Mohammad';
    $password = '7QfAgRrsTb4fjC0Y';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=mygreencard;charset=utf8", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
            $output['error'][]='Databsase Error,'.'Connection failed: ' . $e->getMessage();
    }
    // Store main Applicant Data
    //TrackingCode	isPayed to be inserted later
    try {
        $sql = "INSERT INTO applicant (
        FirstName_fa,LastName_fa,FirstName_en,LastName_en,Gender,BirthDate,
        BirthDate_Georgian,BirthCity,BirthCountry,Address,ZipCode,TelNumber,
        Education,ChildNumber,Email,MaridgStatus,hasSpouse,hasChildren,PhotoURL) 
        VALUES ('
        ".$applicant['FirstName_fa']."','".$applicant['LastName_fa']."',
        '".$applicant['FirstName_en']."','".$applicant['LastName_en']."',
        '".$applicant['Gender']."','".$applicant['BirthDate']."',
        '".$applicant['BirthDate_Georgian']."','".$applicant['BirthCity']."',
        '".$applicant['BirthCountry']."','".$applicant['Address']."',
        '".$applicant['ZipCode']."','".$applicant['TelNumber']."',
        '".$applicant['Education']."','".$applicant['ChildNumber']."',
        '".$applicant['Email']."','".$applicant['MaridgStatus']."',
        '".$hasSpouse."','".$hasChildren."','".$applicant['PhotoURL']."'
        )";
        $conn->exec($sql);
        $last_id = $conn->lastInsertId();
    } catch (PDOException $e) {
            $output['error'][]='Databsase Error,'.'Data Insersion failed(Applicant):'.$e->getMessage();
    }
    // Store Spouse data
    if ($hasSpouse && $last_id) {
        if (!empty($spouse)) { //Checks if action value exist
            // Store main Spouse Data
            try {
                    $sql = "INSERT INTO spouse (
            FirstName_fa,LastName_fa,FirstName_en,LastName_en,Gender,BirthDate,
            BirthDate_Georgian,BirthCity,BirthCountry,PhotoURL,ApplicantID) 
            VALUES ('
            ".$spouse['FirstName_fa']."','".$spouse['LastName_fa']."',
            '".$spouse['FirstName_en']."','".$spouse['LastName_en']."',
            '".$spouse['Gender']."','".$spouse['BirthDate']."',
            '".$spouse['BirthDate_Georgian']."','".$spouse['BirthCity']."',
            '".$spouse['BirthCountry']."','".$spouse['PhotoURL']."','".$last_id."'
            )";
                    $conn->exec($sql);
            } catch (PDOException $e) {
                $output['error'][]='Databsase Error,'.'Data Insersion failed(Spouse):'  . $e->getMessage();
            }
        } else {
            $output['error'][]='No Spouse data is sent';
        }
    }
    // Store Children Data
    if ($hasChildren && $last_id) {
        if (!empty($children)) { //Checks if action value exist
            foreach ($children as $child) {
                try {
                    $sql = "INSERT INTO children (
            FirstName_fa,LastName_fa,FirstName_en,LastName_en,Gender,BirthDate,
            BirthDate_Georgian,BirthCity,BirthCountry,PhotoURL,ApplicantID) 
            VALUES ('
            ".$child['FirstName_fa']."','".$child['LastName_fa']."',
            '".$child['FirstName_en']."','".$child['LastName_en']."',
            '".$child['Gender']."','".$child['BirthDate']."',
            '".$child['BirthDate_Georgian']."','".$child['BirthCity']."',
            '".$child['BirthCountry']."','".$child['PhotoURL']."','".$last_id."'
            )";
                    $conn->exec($sql);
                } catch (PDOException $e) {
                    $output['error'][]='Databsase Error,'.'Data Insersion failed(Children):'.$e->getMessage();
                }
            }
        } else {
            $output['error'][]='No Children data is sent';
        }
    }
    // Store Transaction & Payment ID
    if ( !empty($price) && $last_id) {
        $spouseToo=strtolower($price['SpouseToo'])=='true';            
        try {
            $sql="UPDATE applicant SET TotalCharge='".$price['TotalCharge']."',TransID= '".$_SESSION['TransId']."',spouseToo= '".  $spouseToo."' WHERE ID='".$last_id."'";
            $conn->exec($sql);         
        } catch (PDOException $e) {
            $output['error'][]='Databsase Error,'.'Data Insersion failed(Price):'.$e->getMessage();
        }
    }
    // If every thing goes well generate ,store in DB and return a Tracking Code for the Customer
    if (empty($output['error']) && $last_id) {
        $output['TrackingCode']=random_str(10);
        try {
            $sql="UPDATE applicant SET TrackingCode = '".$output['TrackingCode']."' WHERE ID='".$last_id."'";
            $conn->exec($sql);        
            
        } catch (PDOException $e) {
            $output['error'][]='Databsase Error,'.'Data Insersion failed(Trackimg Code):'  . $e->getMessage();
        }
    }

    //If exists Bank Tracing code Insert it into DB
    if (isset($_SESSION['TraceNumber']) && $last_id) {
        try {
            $sql="UPDATE applicant SET BankTraceNumber = '".$_SESSION['TraceNumber']."' WHERE ID='".$last_id."'";
            $conn->exec($sql);        
            
        } catch (PDOException $e) {
            $output['error'][]='Databsase Error,'.'Data Insersion failed(Bank TraceNumber):'  . $e->getMessage();
        }
    }

    //IF all currect send email for new registration Notification
    if(empty($output['error'])){
        $from='admin@mygreencard.ir';
        $to = 'info@mygreencard.ir';
        $subject = 'New GreenCard Reg Req ID='.$last_id;
        $body = "<html>
                <body>
                <div dir='rtl'>سلام، \n ثبت نام جدید در سایت Mygreen Card\n</div>
                ID=$last_id\n\n\r
                Total Paid= '".$price['TotalCharge']."'\n
                TransID='".$_SESSION['TransId']."'\n
                TrackingCode='".$output['TrackingCode']."'
                </html>
                </body>";
        // $mailStat=sendMail($from,$to,$subject,$body);
        // if(!$mailStat){  // Store Error if No mail is send
        //     $output['error'][]="No Email was Send";
        // }
    }
    // Close Connecton to Database
    if ($conn) {
        $conn=null;
    }
    //Return Message to client
    return ($output);
    }
?>