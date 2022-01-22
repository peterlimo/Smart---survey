<?php
session_start();
require('../connection.php');
if(!$_COOKIE["respondent_id"]) {
    $sql ="INSERT INTO `respondent` (`respondent_id`, `respondent_name`) VALUES (NULL, 'NA');";
    $query= mysqli_query($conn,$sql);
    if ($query) {
        $last_id = mysqli_insert_id($conn);
        $cookie_name = "respondent_id";
        $cookie_value = $last_id;
        $setC=setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
 }
 }
 $sqlRows = "select * from sections";
 $rowsQuery = mysqli_query($conn,$sqlRows);   
 $totalRows =mysqli_num_rows($rowsQuery);

 $quiz = "select * from quiz where section_id = 2 group by group_id";

 $choices = "select * from choices";
 $respondent_id = $_COOKIE["respondent_id"];
 $quizData = mysqli_query($conn, $quiz);
 $choiceData = mysqli_query($conn, $quiz);

 $getG = "select * from quiz_group"; 
 $qq = mysqli_query($conn,$getG);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="../icon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   
   <style>
       body{
           background-color:#d1ffe2;
           font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;
       }
    .likert_list{
    background-color: #fff;
    }
    .likert_list ul{
        margin-top: 5px;
        list-style: none;
    }
    .likert_list ul li{
        display: inline;
        margin-left: 10px;
    }
    .quiz_div{
        padding: 24px;
    }
    #optionId{
        font-size: 14px;
    }
    table td {
        padding: 15px;
        text-align: center;
    }
   </style>
   <?php
    // This is used to submit data for the choices
  

    $my_section_id = 2;
    $int_value = 2;
    $next_id = $int_value+1;
    $previous_id = $int_value-1;
    $cat_no = $_COOKIE["cat_no"];
    if (isset($_POST['submit'])) {
  
        while($row = mysqli_fetch_array($qq))
            {
                $getQuiz ="select * from quiz where group_id =".$row['group_id']." and section_id=2";
                $qQuery = mysqli_query($conn,$getQuiz);
        while($likert = mysqli_fetch_array($qQuery)){
                    $queryId = $likert['quiz_id'];
                    $quizType = $likert['type'];
            if($row['group_type'] == "likert")
            {
                $data = $_POST[$likert['quiz_id']];
                $insertsql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$data','$data','NA')";
               mysqli_query($conn, $insertsql);
            }
            if($row['group_type'] == "mental")
            {
                $mentaldata = $_POST[$likert['quiz_id']];
                $insertsql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$mentaldata','$mentaldata','NA')";
               mysqli_query($conn, $insertsql);
            }
            else if($row['group_type'] == "normal")
            {
                if ($quizType == "checkbox") {
                    $checData = $_POST[$likert['quiz_id']];
                    foreach ($checData as $dt) {
                        $sql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$dt', '$dt','NA')";
                        mysqli_query($conn, $sql);
                     
                    }
                } else if ($quizType == "radio") {
                    $rata = $_POST[$likert['quiz_id']];
                    $sql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$rata','$rata','NA')";
                   mysqli_query($conn, $sql);
                   
                } else if ($quizType == "input") {
                    $inpuData = $_POST[$likert['quiz_id']];
                    $inputSql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', 'NA','$inpuData','NA')";
                    mysqli_query($conn, $inputSql);
                }
            }
            else if($row['group_type'] == "NA")
            {
                if ($quizType == "checkbox") {
                    $checkData = $_POST[$likert['quiz_id']];
                    foreach ($checkData as $dt) {
                        $sql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$dt', '$dt','NA')";
                        mysqli_query($conn, $sql);
                    }
                } else if ($quizType == "radio") {
                    $rdata = $_POST[$likert['quiz_id']];
                    $sql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$rdata','$rdata','NA')";
                    mysqli_query($conn, $sql);
                } else if ($quizType == "input") {
                    $inputData = $_POST[$likert['quiz_id']];
                    $inputSql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', 'NA','$inputData','NA')";
                    mysqli_query($conn, $inputSql);
                }

                else if ($quizType == "location") {
                    $locationData = $_POST['location'];
                    $locationSql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', 'NA','$locationData','NA')";
                    mysqli_query($conn, $locationSql);
                }
           }
            }
  

     
        header("location:sectionThree.php");
    

    }
}

    ?>
</head>

<body>
    <div class="container">
        <div class="row" style="text-align: center;">
            <div class="col-lg-8 p-4 mt-2 col-sm-10 col-md-10 offset-lg-2 offset-md-2 bg-white" style="border-top-right-radius:20px;border-top-left-radius:20px">
                <?php 
                $getTitle = "select * from sections where section_id=2";
                $sQuery = mysqli_query($conn,$getTitle);
                $rowQ = mysqli_fetch_assoc($sQuery);
                echo '<h2>(2) '.$rowQ["section_title"].'</h2>';
            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-sm-10 col-md-10 offset-lg-2 offset-md-2">
            <form action="sectionTwo.php" method="POST">
                <?php

            while($row = mysqli_fetch_array($qq))
            {
         
                if($row['group_type'] =="likert" && $row['section_id'] == $my_section_id)
                {
                    if($row['group_title']!="NA" && $row['section_id'] == $my_section_id ){
                        echo '<div class="mt-2"><h5 style="color:#202124;font-weight: 400;font-family:Roboto">'.$row['group_title'].'</h5></div>';
                        }
                    $getQ ="select * from quiz where group_id =".$row['group_id']." and section_id=2";
                    $gg = mysqli_query($conn,$getQ);
                    echo '<div class="shadow-md bg-white quiz_div mt-2" style="border-radius:8px;">';
                    echo '<table  class="table table-striped">
                    <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Strong Agree</th>
                      <th scope="col">Agree</th>
                      <th scope="col">Neutral</th>
                      <th scope="col">Disagree</th>
                      <th scope="col">Strongly Disagree</th>
                    </tr>
                  </thead>
                  <tbody>
                    ';
                    while($rowQ = mysqli_fetch_assoc($gg))
                        {
                        
                            echo '<tr>
                            <th style="width:100px;font-size:14px;" scope="row">'.$rowQ['quiz'].'</th>
                            ';
                            $radioData = "select * from choices where quiz_id=" . $rowQ['quiz_id'];
                            $radioQ = mysqli_query($conn, $radioData);
                            if (mysqli_num_rows($radioQ) > 0) {
                                echo '<div class="likert_list"><ul>';
                                while ($rowRadio = mysqli_fetch_array($radioQ)) {

                                    echo '<td align="center" id='.$rowRadio['id'].' style="text-align:center;margin:auto"><input type="radio" value="' . $rowRadio['id'] . '" name="' . $rowQ['quiz_id'] . '" id='.$rowRadio['id'].'></td>';    
                               
                                }
                                echo '</ul></div>';
                            }
                           echo '
                          </tr>';
                        }
                        echo '</tbody></table>';
                    echo "</div>";
                }
                else if($row['group_type'] =="mental" && $row['section_id'] == $my_section_id)
                {
                    if($row['group_title']!="NA" && $row['section_id'] == $my_section_id ){
                        echo '<div class="mt-2"><h5 style="color:#202124;font-weight: 400;font-family:Roboto">'.$row['group_title'].'</h5></div>';
                        }
                    $getQ ="select * from quiz where group_id =".$row['group_id']." and section_id=2";
                    $gg = mysqli_query($conn,$getQ);
                    echo '<div class="shadow-md bg-white quiz_div mt-2" style="border-radius:8px;">';
                    echo '<table  class="table table-striped">
                    <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">Not at all</th>
                      <th scope="col">Several days</th>
                      <th scope="col">More than half the days</th>
                      <th scope="col">Nearly every day</th>
                    </tr>
                  </thead>
                  <tbody>
                    ';
                    while($rowQ = mysqli_fetch_assoc($gg))
                        {
                        
                            echo '<tr>
                            <th style="width:100px;font-size:14px;" scope="row">'.$rowQ['quiz'].'</th>
                            ';
                            $radioData = "select * from choices where quiz_id=" . $rowQ['quiz_id'];
                            $radioQ = mysqli_query($conn, $radioData);
                            if (mysqli_num_rows($radioQ) > 0) {
                                echo '<div class="likert_list"><ul>';
                                while ($rowRadio = mysqli_fetch_array($radioQ)) {

                                    echo '<td align="center" id='.$rowRadio['id'].' style="text-align:center;margin:auto"><input type="radio" value="' . $rowRadio['id'] . '" name="' . $rowQ['quiz_id'] . '" id='.$rowRadio['id'].'></td>';    
                               
                                }
                                echo '</ul></div>';
                            }
                           echo '
                          </tr>';
                        }
                        echo '</tbody></table>';
                    echo "</div>";
                }
                else{
                    if($row['group_title']!="NA" && $row['section_id'] == $my_section_id ){
                        echo '<div class="mt-2"><h5 style="color:#202124;font-weight: 400;font-family:Roboto">'.$row['group_title'].'</h5></div>';
                        }
                $getQ ="select * from quiz where group_id =".$row['group_id']." and section_id=2";
                $gg = mysqli_query($conn,$getQ);
                while($row1 = mysqli_fetch_assoc($gg))
                {
                    echo '<div class="shadow-md bg-white quiz_div mt-2" style="border-radius:8px;"><h5  style="font-weight:bold;font-size: 18px;letter-spacing: .1px;word-break: break-word;color:#202124;font-weight: 400;font-family:Roboto;">'.$row1['quiz'].'</h5>';    
                    if ($row1['type'] == "input") {
                        echo
                        '<div class="inputholder">
                            <textarea name="'.$row1['quiz_id'].'" placeholder="Type your Answer" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea><br>
                         </div>';
                    }

                    else if ($row1['type'] == "checkbox" && $row['group_type'] == "NA") {
                        $checkData = "select * from choices where quiz_id=" . $row1['quiz_id'];
                        $checkQ = mysqli_query($conn, $checkData);
                        if (mysqli_num_rows($checkQ) > 0) {
                            while ($rowCheck = mysqli_fetch_array($checkQ)) {
                                echo '
                                <input type="checkbox" value="' . $rowCheck['id'] . '" name="' . $row1['quiz_id'] . '[]" id="radio1">' . '    ' . $rowCheck['choice'] . '<br>
                                ';
                            }
                        }
                    }
                    else if ($row1['type'] == "radio" && $row['group_type'] == "NA") {

                        $radioData = "select * from choices where quiz_id=" . $row1['quiz_id'];
                        $radioQ = mysqli_query($conn, $radioData);
                        if (mysqli_num_rows($radioQ) > 0) {

                            while ($rowRadio = mysqli_fetch_array($radioQ)) {
                                if($rowRadio['choice'] == "Other")
                                {
                                    echo "othercxcx";
                                }
                                else{
                                    echo '<div class="radioholder m-1">
                                     <input type="radio" value="' . $rowRadio['id'] . '" name="' . $row1['quiz_id'] . '" id='.$rowRadio['id'].'><label id="optionId" for='.$rowRadio['id'].' style="margin-left:10px; width:70%">' . '    ' . $rowRadio['choice'] . '<br>
                                    </label></div>';
                                }
                            }
                        }
                    }
                    else if ($row1['type'] == "location" && $row['group_type'] == "NA") {

                        $locationData = "select * from counties";
                        $locationQ = mysqli_query($conn, $locationData);
                        if (mysqli_num_rows($locationQ) > 0) {
                            echo '<input class="form-control" list="datalistOptions" id="exampleDataList" name="location" placeholder="Type to search...">
                            <datalist id="datalistOptions">';
                            while ($rowLocation = mysqli_fetch_array($locationQ)) {
                                echo '<option value="' . $rowLocation['name'] . '">';
                            }
                            echo '</datalist>';
                        }
                    }
                    else if ($row1['type'] == "radio" && $row['group_type'] == "normal") {

                        $radioData = "select * from choices where quiz_id=" . $row1['quiz_id'];
                        $radioQ = mysqli_query($conn, $radioData);
                        if (mysqli_num_rows($radioQ) > 0) {

                            while ($rowRadio = mysqli_fetch_array($radioQ)) {
                                echo '<div style="margin-left:20px;" class="radioholder m-2">
                                <input type="radio" value="' . $rowRadio['id'] . '" name="' . $row1['quiz_id'] . '" id='.$rowRadio['id'].'><label for='.$rowRadio['id'].' style="margin-left:10px;">' . '    ' . $rowRadio['choice'] . '<br>
                                </label></div>';
                            }
                        }
                    }
                    else if ($row1['type'] == "radio" && $row1['group_type'] == "likert") {
                        $radioData = "select * from choices where quiz_id=" . $row1['quiz_id'];
                        $radioQ = mysqli_query($conn, $radioData);
                        if (mysqli_num_rows($radioQ) > 0) {
                            echo '<div class="likert_list"><ul>';
                            while ($rowRadio = mysqli_fetch_array($radioQ)) {
                                
                                echo '<li>
                                <input type="radio" value="' . $rowRadio['id'] . '" name="' . $row1['quiz_id'] . '" id='.$rowRadio['id'].'><label for='.$rowRadio['id'].' style="margin-left:10px;color:#143fdb;">' . '    ' . $rowRadio['choice'] . '<br>
                                </label></li>';
                               
                            }
                            echo '</ul></div>';
                        }
                    }

                 echo '</div>';
                }
            }
            }
            ?>
                <input id="submitBtn" type="submit" class="btn btn-outline-primary mt-2 mb-4" style="float: right;width:100%" name="submit"></button>
            </form>
            <?php
        
                $sqlPrevious = "select * from sections where section_id=2";
                $q1 = mysqli_query($conn,$sqlPrevious);
                $rowPrevious =  mysqli_fetch_assoc($q1);
            $sqlSection="select * from sections where section_id=".$next_id;
            $q=mysqli_query($conn,$sqlSection);
            $rowSection = mysqli_fetch_assoc($q);
              echo '<div style="height: 100px; text-align:center" class="col-lg-12 w-5 shadow col-md-12"><a href="test1.php?section_id='.$next_id.'"  id="open_section_link"> next:->' . $rowSection['section_title'] . '</a></div>';
            
          ?>
           </div>
        </div>
    </div>
    <script>
        var submitBtn = document.getElementById("submitBtn");
        $(document).on('click','td',function(){
    $(this).find('input [type="radio"]').prop('checked',true)
    });
    </script>
</body>

</html>