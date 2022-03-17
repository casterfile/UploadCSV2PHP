<?php
// Load the database configuration file
include_once 'dbConfig.php';

//echo "Output: Begins";

//echo "Output: Start";

// Allowed mime types
$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

// Validate whether selected file is a CSV file
if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
    
    // If the file is uploaded
    if(is_uploaded_file($_FILES['file']['tmp_name'])){
        
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
        
        // Skip the first line
        fgetcsv($csvFile);
        
        // Parse data from CSV file line by line
        while(($line = fgetcsv($csvFile)) !== FALSE){
            // Get row data
            $Name   = $line[0];
            $Department   = $line[1];
            $Email  = $line[2];
            $Password = $line[3];
            $Roles = $line[4];
            $Section = $line[5];
            $Year_Level  = $line[6];
            $Course  = $line[7];
            
            //echo "Output Email: ". $Email;
            // Check whether member already exists in the database with the same email
            $prevQuery = "SELECT Email FROM user WHERE Email = '".$line[2]."'";
            $prevResult = $db->query($prevQuery);
            
            if($prevResult->num_rows > 0){
                // Update member data in the database
                $db->query("UPDATE user SET Name = '".$Name."', Department   = '".$Department."'
                    , Email = '".$Email."'
                    , Password = '".$Password."'
                    , Roles = '".$Roles."'
                    , Section = '".$Section."'
                    , Year_Level = '".$Year_Level."'
                    , Course = '".$Course."' WHERE Email = '".$Email."'");
            }else{
                // Insert member data in the database
                $db->query("INSERT INTO user (Name, Department, Email , Password, Roles, Section,Year_Level,Course) VALUES ('".$Name."', '".$Department."', '".$Email."', '".$Password."', '".$Roles."', '".$Section."', '".$Year_Level."', '".$Course."')");
            }
        }
        
        // Close opened CSV file
        fclose($csvFile);
        
         $qstring = 'succ';
         echo "done";
    }else{
        $qstring = 'err';
        echo "error";
    }
}else{
    $qstring = 'invalid_file';
    echo "invalid_file";
}


?>