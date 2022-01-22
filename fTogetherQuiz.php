<?php
session_start();
echo $_COOKIE["respondent_id"];
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
    require('connection.php');
    $quiz = "select * from quiz where section_id=" . $_GET['section_id'];
    $choices = "select * from choices";
$respondent_id = $_COOKIE["respondent_id"];
    $quizData = mysqli_query($conn, $quiz);
    $choiceData = mysqli_query($conn, $quiz);
    $my_section_id = $_GET['section_id'];
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
    }
    ?>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <a class="navbar-brand" href="#"><img src="logo-blue.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="createQuiz.php">Creat Quiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Answer Quiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="statistics.php">Statistics</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row">

            <form action="fTogetherQuiz.php?section_id=" .<?php $my_section_id ?> method="GET">
                <input type="hidden" name="section_id" value="<?= $my_section_id ?>" />
                <?php
                while ($row = mysqli_fetch_array($quizData)) {
                    if($row['group_id'] == "NA")
                    {

                   
                    echo '<div class="col-lg-12 shadow-lg m-2 p-3 rounded">';
                    echo '<h5>' . $row['quiz'] . '</h5>';
                    if ($row['type'] == "input") {
                        echo
                        '<div class="inputholder">
                            <textarea name="'.$row['quiz_id'].'" placeholder="Type your Answer" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea><br>
                         </div>';
                    } else if ($row['type'] == "checkbox") {
                        $checkData = "select * from choices where quiz_id=" . $row['quiz_id'];
                        $checkQ = mysqli_query($conn, $checkData);
                        if (mysqli_num_rows($checkQ) > 0) {
                            while ($row1 = mysqli_fetch_array($checkQ)) {
                                echo '<div class="checkholder m-2">
                                <input type="checkbox" value="' . $row1['id'] . '" name="' . $row['quiz_id'] . '[]" id="radio1">' . '    ' . $row1['choice'] . '<br>
                                </div>';
                            }
                        }
                    } else if ($row['type'] == "radio") {

                        $radioData = "select * from choices where quiz_id=" . $row['quiz_id'];
                        $radioQ = mysqli_query($conn, $radioData);
                        if (mysqli_num_rows($radioQ) > 0) {

                            while ($row2 = mysqli_fetch_array($radioQ)) {
                                echo '<div class="radioholder m-2">
                                <input type="radio" value="' . $row2['id'] . '" name="' . $row['quiz_id'] . '" id="radio1">' . '    ' . $row2['choice'] . '<br>
                                </div>';
                            }
                        }
                    }

                    echo '</div>';
                }
                else
                {
                    $selectGroupTitle = "select group_title from quiz_group where group_id=".$row['group_id']." group by group_title";
                    $gIduery= mysqli_query($conn,$selectGroupTitle);
                    $rowGid = mysqli_fetch_array($gIduery);
                    echo '<p style="font-size:10px">' . $rowGid['group_title'] . '</p>';
                    echo $row['group_id'];
                }
            }
                ?>
                <input type="submit" class="btn btn-primary" name="submit"></button>
            </form>
        </div>
    </div>
</body>

</html>