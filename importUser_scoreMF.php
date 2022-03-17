<?php
// Load the database configuration file
include_once 'dbConfig.php';

//echo "Output: Begins";

//echo "Output: Start";

// Allowed mime types
$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

//echo "Output Start Outer If";
// Validate whether selected file is a CSV file
if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
    

    //echo "Output Start Inner If";
    // If the file is uploaded
    if(is_uploaded_file($_FILES['file']['tmp_name'])){
        
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
        
        // Skip the first line
        fgetcsv($csvFile);
        
        //echo "Output Start Whileloop";
        // Parse data from CSV file line by line
        while(($line = fgetcsv($csvFile)) !== FALSE){
            // Get row data
            $TAR_Number   = $line[0];
            $Email   = $line[1];
            $MF1  = $line[2];
            $MF2 = $line[3];
            $MF3 = $line[4];
            $MF4 = $line[5];
            $MF5  = $line[6];
            $MF6  = $line[7];
            $MF7 = $line[8];
            $MF8  = $line[9];
            $MF9  = $line[10];
            $MF10 = $line[11];
            $MF11  = $line[12];
            $MF12  = $line[13];
            $MF13 = $line[14];
            $MF14  = $line[15];
            $MF15  = $line[16];
            $MF16  = $line[17];
            $MF17  = $line[18];
            
            //echo "Output TAR_Number: ". $TAR_Number;
            // Check whether member already exists in the database with the same email
            $prevQuery = "SELECT TAR_Number FROM user_scoremf WHERE TAR_Number = '".$line[0]."'";
            $prevResult = $db->query($prevQuery);
            
            if($prevResult->num_rows > 0){

                $sql = $db->query("UPDATE user_scoremf SET TAR_Number = '".$TAR_Number."', Email   = '".$Email."'
                    , MF1 = '".$MF1."'
                    , MF2 = '".$MF2."'
                    , MF3 = '".$MF3."'
                    , MF4 = '".$MF4."'
                    , MF5 = '".$MF5."'
                    , MF6 = '".$MF6."'
                    , MF7 = '".$MF7."'
                    , MF8 = '".$MF8."'
                    , MF9 = '".$MF9."'
                    , MF10 = '".$MF10."'
                    , MF11 = '".$MF11."'
                    , MF12 = '".$MF12."'
                    , MF13 = '".$MF13."'
                    , MF14 = '".$MF14."'
                    , MF15 = '".$MF15."'
                    , MF16 = '".$MF16."'
                    , MF17 = '".$MF17."' WHERE TAR_Number = '".$TAR_Number."'");

                /*if (mysqli_query($db, $sql)) {
                      //echo "New record created successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($db);
                }*/
            }else{
                    
                    // Insert member data in the database
                    $sql = "INSERT INTO user_scoremf  VALUES ('".$TAR_Number."', '".$Email."', '".$MF1."', '".$MF2."', '".$MF3."'

                    , '".$MF4."'
                    , '".$MF5."'
                    , '".$MF6."'
                    , '".$MF7."'
                    , '".$MF8."'
                    , '".$MF9."'
                    , '".$MF10."'
                    , '".$MF11."'
                    , '".$MF12."'
                    , '".$MF13."'
                    , '".$MF14."'
                    , '".$MF15."'
                    , '".$MF16."', '".$MF17."')";
                    if (mysqli_query($db, $sql)) {
                      //echo "New record created successfully";
                    } else {
                      //echo "Error: " . $sql . "<br>" . mysqli_error($db);
                    }
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