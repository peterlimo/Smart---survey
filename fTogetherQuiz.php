<?php
require('connection.php');
$quiz = "select * from quiz";
$choices = "select * from choices";

$quizData = mysqli_query($conn, $quiz);
$choiceData = mysqli_query($conn, $quiz);
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
                        <a class="nav-link" href="fTogetherQuiz.php">Answer Quiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="statistics.php">Statistics</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-4">

            </div>
            <form action="post">
            <?php
            while ($row = mysqli_fetch_array($quizData)) {
                echo '<h5>' . $row['quiz'] . '</h5>';
                if ($row['type'] == "input") {
                    echo '<div class="inputholder">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea><br>
                        </div>';
                } else if ($row['type'] == "checkbox") {
                    $checkData = "select * from choices where quiz_id=" . $row['quiz_id'];
                    $checkQ = mysqli_query($conn, $checkData);
                    if (mysqli_num_rows($checkQ) > 0) {

                        while ($row1 = mysqli_fetch_array($checkQ)) {
                            echo '<div class="checkholder">
                                <input type="checkbox" name="raido1" id="radio1">' . $row1['choice'] . '<br>
                                </div>';
                        }
                    }
                } else if ($row['type'] == "radio") {

                    $radioData = "select * from choices where quiz_id=" . $row['quiz_id'];
                    $radioQ = mysqli_query($conn, $radioData);
                    if (mysqli_num_rows($radioQ) > 0) {

                        while ($row2 = mysqli_fetch_array($radioQ)) {
                            echo '<div class="radioholder">
                                <input type="radio" name="raido1" id="radio1">' . $row2['choice'] . '<br>
                                </div>';
                        }
                    }
                }
            }
            ?>
            <input type="submit" class="btn btn-primary" name="submit"></button>
            </form>
        </div>
    </div>
</body>

</html>