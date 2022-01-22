<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionaire Categories</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <?php
    require('../connection.php');
    ?>
</head>

<body>
    <div class="container">


    <div class="accordion accordion-flush" id="accordionFlushExample">
            <?php
            $sec_id = $_GET['section_id'];
            $groupSql = "select * from quiz_group";
            $qQuery = mysqli_query($conn,$groupSql); 

            while($row1 = mysqli_fetch_array($qQuery))
            {
                if($row1['group_type'] =="likert" && $row1['section_id'] == $sec_id)
                {
                    if($row1['group_title']!="NA" && $row1['section_id'] == $sec_id ){
                        
                        echo "Heading";
                    }

                }
            }
            $sql = "select * from quiz where section_id=" . $sec_id;
            $query = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($query)) {
              echo '<div class="accordion-item">'.
                    '<h2 class="accordion-header" id="flush-headingTwo">'.
                        '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo'.$row['quiz_id'].'" aria-expanded="false" aria-controls="flush-collapseTwo'.$row['quiz_id'].'">'.
                         $row['quiz']
                        .'</button>'.
                    '</h2>'.
                    '<div id="flush-collapseTwo'.$row['quiz_id'].'" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">';
                
                    if($row['type'] == "input"){
                        $inputChoiceId="NA";
                        $sqlInputAnswers ="select * from answers where quiz_id=".$row['quiz_id'];
                        $inputQuery = mysqli_query($conn, $sqlInputAnswers);
                        while($inputRow = mysqli_fetch_array($inputQuery))
                        {
                            echo '<div class="accordion-body">'.$inputRow['answer'].'</div>';
                        }
                        }
                        else if($row['type'] == "checkbox"){
                            $inputChoiceId="NA";
                            $id=$row['quiz_id'];
                            $sqlInputCheckbox ="select * from answers where quiz_id=".$id." group by choice_id";
                            $checkboxQuery = mysqli_query($conn, $sqlInputCheckbox);
                            while($checkboxRow = mysqli_fetch_array($checkboxQuery))
                            { 
                                $getText= "select choice from choices where id=".$checkboxRow['choice_id'];
                                echo $getText;
                                $textQ= mysqli_query($conn,$getText);
                                $roee= mysqli_fetch_array($textQ);
                                $getCount = "select * from answers where choice_id=".$checkboxRow['choice_id'];
                                $countQ= mysqli_query($conn,$getCount);
                                $rowCount= mysqli_num_rows($countQ);
                                echo '<div class="accordion-body">'.$roee['choice'].' -> '.$rowCount.' responses</div>';
                            }
                            // .$checkboxRow['choice_id']
                        }
                        else if($row['type'] == "radio")
                        {
                            $id=$row['quiz_id'];
                            $sqlInputRadio="select * from answers where quiz_id=".$id." group by answer";
                            $radioQuery = mysqli_query($conn, $sqlInputRadio);
                            while($radioRow = mysqli_fetch_array($radioQuery))
                            { 
                                $getText= "select * from choices where id=".$radioRow['answer'];
                                echo $getText;
                                $textQ= mysqli_query($conn,$getText);
                                $roee= mysqli_fetch_array($textQ);
                                $getCount = "select * from answers where choice_id=".$radioRow['answer'];
                                $countQ= mysqli_query($conn,$getCount);
                                $rowCount= mysqli_num_rows($countQ);
                                echo '<div class="accordion-body">'.$roee['choice'].'->'.$rowCount.' responses</div>';
                            }
                            // .$radioRow['choice_id']
                        }
                    echo '</div>'.
                '</div>';
            }
        
            ?>
        </div>
    </div>
</body>

</html>