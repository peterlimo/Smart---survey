<?php
session_start();
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <?php
    // This is used to submit data for the choices
    require('../connection.php');
    $quiz = "select * from quiz where section_id=" . $_GET['section_id']. " group by group_id";

    $choices = "select * from choices";
    $respondent_id = $_COOKIE["respondent_id"];
    $quizData = mysqli_query($conn, $quiz);
    $choiceData = mysqli_query($conn, $quiz);



    $my_section_id = $_GET['section_id'];
    $int_value = intval($_GET['section_id']);
    $next_id = $int_value+1;
    $previous_id = $int_value-1;
    $cat_no = $_COOKIE["cat_no"];
    if (isset($_GET['submit'])) {
        while ($qRow = mysqli_fetch_array($quizData)) {
            $queryId = $qRow['quiz_id'];
            $quizType = $qRow['type'];
            $choices = "select * from choices where quiz_id=" . $queryId;
            $cQuery = mysqli_query($conn, $choices);
            $cRow = mysqli_fetch_array($cQuery);
            echo '<div>' . $qRow['quiz_id'] . '</div>';
            if ($quizType == "checkbox") {
                $checkData = $_GET[$qRow['quiz_id']];
                foreach ($checkData as $dt) {
                    $sql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$dt', '$dt','NA')";
                    mysqli_query($conn, $sql);
                }
            } else if ($quizType == "radio") {
                $data = $_GET[$qRow['quiz_id']];
                $sql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', '$data','$data','NA')";
                mysqli_query($conn, $sql);
            } else if ($quizType == "input") {
                $inputData = $_GET[$qRow['quiz_id']];
                $inputSql = "INSERT INTO `answers` (`answer_id`, `quiz_id`, `respondent_id`,`choice_id`,`answer`,`text`) VALUES (NULL,'$queryId', '$respondent_id', 'NA','$inputData','NA')";
                mysqli_query($conn, $inputSql);
            }
        }
        if($_GET['section_id']<$cat_no || $_GET['section_id']>0){
        header("location:survey.php?section_id=".$next_id);

        }
        else{
            header("location:done.php");
        }
    }
    ?>
</head>

<body>
    <div class="container">
        <div class="row" style="text-align: center;">
            <h1>Peter Kiprop</h1>
        </div>
        <div class="row">
            <form action="survey.php?section_id= .<%= $my_section_id %>" method="GET">
                <input type="hidden" name="section_id" value="<?= $my_section_id ?>" />
          <?php
            $row = mysqli_fetch_array($quizData);
            
            while($row = mysqli_fetch_array($quizData))
            {
                echo '<div>'.$row['quiz'].'</div>';
                $selelectGroup ="select * from quiz_group where group_id = 2";
             
                $gQuery = mysqli_query($conn,$selelectGroup);
                $rowG =mysqli_fetch_assoc($gQuery);
               
                echo $rowG['group_title'];
                
            }
            // echo $row['group_id'][1];
            // if($row['group_id']=="NA"){
            //     $id ="NA";
            //     $ssql ="select * from quiz where group_id !=".$id;
            //     $ssqury = mysqli_query($conn,$ssql);
            //     while ($row = mysqli_fetch_assoc($ssqury)) {
              
                    

            //             echo '<div class="col-lg-12 shadow-sm m-2 p-3 rounded">';
            //         echo '<h6>' . $row['quiz'] . '</h6>';

            //         if ($row['type'] == "input" && $row['group_id'] == "NA") {
            //             echo '<div class="inputholder">
            //                 <textarea name="'.$row['quiz_id'].'" placeholder="Type your Answer" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea><br>
            //              </div>';
            //         } else if ($row['type'] == "checkbox" && $row['group_id'] == "NA") {
            //             $checkData = "select * from choices where quiz_id=" . $row['quiz_id'];
            //             $checkQ = mysqli_query($conn, $checkData);
            //             if (mysqli_num_rows($checkQ) > 0) {
            //                 while ($row1 = mysqli_fetch_array($checkQ)) {
            //                     echo '<div class="checkholder m-2">
            //                     <input type="checkbox" value="' . $row1['id'] . '" name="' . $row['quiz_id'] . '[]" id="radio1">' . '    ' . $row1['choice'] . '<br>
            //                     </div>';
            //                 }
            //             }
            //         } else if ($row['type'] == "radio" && $row['group_id'] == "NA") {

            //             $radioData = "select * from choices where quiz_id=" . $row['quiz_id'];
            //             $radioQ = mysqli_query($conn, $radioData);
            //             if (mysqli_num_rows($radioQ) > 0) {

            //                 while ($row2 = mysqli_fetch_array($radioQ)) {
            //                     echo '<div class="radioholder m-2">
            //                     <input type="radio" value="' . $row2['id'] . '" name="' . $row['quiz_id'] . '" id="radio1">' . '    ' . $row2['choice'] . '<br>
            //                     </div>';
            //                 }
            //             }
            //         }
                    // else if ($row['type'] == "radio" && $row['group_id'] != "NA") {
                    //         $tes=true;
                    //         echo "dsds";
                    //     // $radioData = "select * from choices where quiz_id=" . $row['quiz_id'];
                    //     // $radioQ = mysqli_query($conn, $radioData);
                    //     // if (mysqli_num_rows($radioQ) > 0) {

                    //     //     while ($row2 = mysqli_fetch_array($radioQ)) {
                    //     //         echo '<div class="radioholder m-2">
                    //     //         <input type="radio" value="' . $row2['id'] . '" name="' . $row['quiz_id'] . '" id="radio1">' . '    ' . $row2['choice'] . '<br>
                    //     //         </div>';
                    //     //     }
                    //     // }
                    // }
                    // echo '</div>';
                    // }}

                    // else{
                    //     echo "ggjj";
                         
                    // }
                   
              
                
                    // $selectGroupTitle = "select group_title from quiz_group where group_id=".$row['group_id']." group by group_title";
                    // $gIduery= mysqli_query($conn,$selectGroupTitle);
                    // $rowGid = mysqli_fetch_array($gIduery);
                    // echo '<p style="font-size:10px">' . $rowGid['group_title'] . '</p>';
                    // echo $row['group_id'];
                
            
                ?>
                <input id="submitBtn" type="submit" class="btn btn-primary" name="submit"></button>
            </form>
            <?php
            if($next_id<=$cat_no && $_GET['section_id']>0){
                $sqlPrevious = "select * from sections where section_id=".$previous_id;
                $q1 = mysqli_query($conn,$sqlPrevious);
                $rowPrevious =  mysqli_fetch_assoc($q1);
            $sqlSection="select * from sections where section_id=".$next_id;
            $q=mysqli_query($conn,$sqlSection);
            $rowSection = mysqli_fetch_assoc($q);
            echo $rowSection['section_title'];
              echo '<div style="height: 100px; text-align:center" class="col-lg-12 w-5 shadow col-md-12"><a href="survey.php?section_id='.$next_id.'"  id="open_section_link"> next:->' . $rowSection['section_title'] . '</a></div>';
            }
            else{
                echo "aa";
            }
          
          ?>
           
        </div>
    </div>
    <script>
        var submitBtn = document.getElementById("submitBtn");


    </script>
</body>

</html>