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
            $user_scoreDate  = $line[2];
            $user_scoreTime = $line[3];
            $Total_Time = $line[4];
            $Weight_touching_the_ground_outside_of_the_42_circle_VALUE = $line[5];
            $Weight_touching_the_ground_outside_of_the_42_circle_TRIGGER  = $line[6];
            $Weight_touching_the_ground_outside_of_the_42_circle_DEDUCTION  = $line[7];

            $Weight_touching_any_part_of_the_course_VALUE = $line[8];
            $Weight_touching_any_part_of_the_course_TRIGGER  = $line[9];
            $Weight_touching_any_part_of_the_course_DEDUCTION  = $line[10];

            $Stopping_while_lowering_Test_Weight_VALUE = $line[11];
            $Stopping_while_lowering_Test_Weight_TRIGGER  = $line[12];
            $Stopping_while_lowering_Test_Weight_DEDUCTION  = $line[13];

            $Exceeding_the_optimum_time_VALUE = $line[14];
            $Exceeding_the_optimum_time_TRIGGER  = $line[15];
            $Exceeding_the_optimum_time_DEDUCTION  = $line[16];

            $FaultType  = $line[17];
            $WeatherType  = $line[18];
            $ShipType  = $line[19];
            $ExerciseType  = $line[20];
            $GameMode  = $line[21];
            
            //echo "Output TAR_Number: ". $TAR_Number;
            // Check whether member already exists in the database with the same email
            $prevQuery = "SELECT TAR_Number FROM user_score WHERE TAR_Number = '".$line[0]."'";
            $prevResult = $db->query($prevQuery);
            
            if($prevResult->num_rows > 0){

                $sql = $db->query("UPDATE user_score SET TAR_Number = '".$TAR_Number."', Email   = '".$Email."'
                    , user_scoreDate = '".$user_scoreDate."'
                    , user_scoreTime = '".$user_scoreTime."'
                    , Total_Time = '".$Total_Time."'
                    , Weight_touching_the_ground_outside_of_the_42_circle_VALUE = '".$Weight_touching_the_ground_outside_of_the_42_circle_VALUE."'
                    , Weight_touching_the_ground_outside_of_the_42_circle_TRIGGER = '".$Weight_touching_the_ground_outside_of_the_42_circle_TRIGGER."'
                    , Weight_touching_the_ground_outside_of_the_42_circle_DEDUCTION = '".$Weight_touching_the_ground_outside_of_the_42_circle_DEDUCTION."'

                    , Weight_touching_any_part_of_the_course_VALUE = '".$Weight_touching_any_part_of_the_course_VALUE."'
                    , Weight_touching_any_part_of_the_course_TRIGGER = '".$Weight_touching_any_part_of_the_course_TRIGGER."'
                    , Weight_touching_any_part_of_the_course_DEDUCTION = '".$Weight_touching_any_part_of_the_course_DEDUCTION."'

                    , Stopping_while_lowering_Test_Weight_VALUE = '".$Stopping_while_lowering_Test_Weight_VALUE."'
                    , Stopping_while_lowering_Test_Weight_TRIGGER = '".$Stopping_while_lowering_Test_Weight_TRIGGER."'
                    , Stopping_while_lowering_Test_Weight_DEDUCTION = '".$Stopping_while_lowering_Test_Weight_DEDUCTION."'

                    , Exceeding_the_optimum_time_VALUE = '".$Exceeding_the_optimum_time_VALUE."'
                    , Exceeding_the_optimum_time_TRIGGER = '".$Exceeding_the_optimum_time_TRIGGER."'
                    , Exceeding_the_optimum_time_DEDUCTION = '".$Exceeding_the_optimum_time_DEDUCTION."'


                    , FaultType = '".$FaultType."'
                    , WeatherType = '".$WeatherType."'
                    , ShipType = '".$ShipType."'
                    , ExerciseType = '".$ExerciseType."'

                    , GameMode = '".$GameMode."' WHERE TAR_Number = '".$TAR_Number."'");

                /*if (mysqli_query($db, $sql)) {
                      //echo "New record created successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($db);
                }*/
            }else{
                    
                    // Insert member data in the database
                    $sql = "INSERT INTO user_score  VALUES ('".$TAR_Number."', '".$Email."', '".$user_scoreDate."', '".$user_scoreTime."', '".$Total_Time."'

                    , '".$Weight_touching_the_ground_outside_of_the_42_circle_VALUE."'
                    , '".$Weight_touching_the_ground_outside_of_the_42_circle_TRIGGER."'
                    , '".$Weight_touching_the_ground_outside_of_the_42_circle_DEDUCTION."'
                    
                    , '".$Weight_touching_any_part_of_the_course_VALUE."'
                    , '".$Weight_touching_any_part_of_the_course_TRIGGER."'
                    , '".$Weight_touching_any_part_of_the_course_DEDUCTION."'
                    
                    , '".$Stopping_while_lowering_Test_Weight_VALUE."'
                    , '".$Stopping_while_lowering_Test_Weight_TRIGGER."'
                    , '".$Stopping_while_lowering_Test_Weight_DEDUCTION."'
                    
                    , '".$Exceeding_the_optimum_time_VALUE."'
                    , '".$Exceeding_the_optimum_time_TRIGGER."'
                    , '".$Exceeding_the_optimum_time_DEDUCTION."'

                    , '".$FaultType."', '".$WeatherType."', '".$ShipType."', '".$ExerciseType."', '".$GameMode."')";

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