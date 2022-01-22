<?php
session_start();
require("../connection.php");
if(!$_COOKIE["respondent_id"]) {
$sql ="INSERT INTO `respondent` (`respondent_id`, `respondent_name`) VALUES (NULL, 'NA');";
$query= mysqli_query($conn,$sql);
if ($query) {
    $last_id = mysqli_insert_id($conn);
    
    $cookie_name = "respondent_id";
    $cookie_value = $last_id;
    $setC=setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    if($setC)
    {
        echo "Cokie of last inserted id set successfully";
    }
}
}else{
    echo "You cokie is already set to ".$_COOKIE["respondent_id"];
}
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
    $sql = "select * from sections";
    $query = mysqli_query($conn, $sql);
    
    ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($query)) {
                $sqlCount = "select count(*) from quiz where section_id=" . $row['section_id'];
                $result = mysqli_query($conn, $sqlCount);
                $row1 = mysqli_fetch_assoc($result);
                $count = $row1["count(*)"];
                echo '<div style="height: 100px; text-align:center" class="col-lg-12 w-5 shadow col-md-12"><a href="fTogetherQuiz.php?section_id='.$row['section_id'].'"  id="open_section_link">' . $row['section_title'] . " ($count)" . '</a></div>';
            }
            ?>
        </div>
    </div>
</body>

</html>