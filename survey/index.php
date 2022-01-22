<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Father Together- Kenya Chapter baseline survey, when we empower a father we empower a family, when we empower a family we build a great nation!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <link rel="icon" href="../icon.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<style>
    *{
        font-family: Roboto;
    }
</style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 d-flex align-items-center justify-content-center" style="text-align: center;">
                <img src="../icon.png" alt="" style="height: 130px;width:130px;">
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-lg-12 col-sm-12 col-md-12" style="text-align: center;">
                <h3 style="color: #1878ed;">Fathering Together - Kenya Chapter Baseline Survey</h3>
            </div>
        </div>
        <div class="row mt-3" style="text-align: center;">
            <p>To help Fathers achieve their parenting goals and obligations while also making them realize how important they are to their families, Fathering Together Kenya Chapter is conducting a baseline survey to collect views from fathers on the areas that need intervention.</p>
         </div>
        <div class="row" style="text-align: center;">
            <p>Therefore, we kindly request you to complete the survey below. Your feedback will be highly appreciated and of great importance to Fathering Together Mental Health and Wellness initiative for dads.</p>
        </div>
         <div class="row" style="text-align: center;">
        Kindly note that the survey is anonimous and will not reveal the identity of the respondends. The results will only be used for the purposes of coming up with mental health and wellness initiative for dads program.
          </div>
        <div class="row d-flex align-items-center" style="text-align:center">
            <h5>You will be asked questions based on the following major categories :-</h5>
            <?php
            require('../connection.php');
            $sql = "select * from sections";
            $query = mysqli_query($conn, $sql);

            $cookie_name = "cat_no";

            $setC = setcookie($cookie_name, mysqli_num_rows($query), time() + (86400 * 30), "/"); // 86400 = 1 day

            while ($row = mysqli_fetch_array($query)) {
                $sqlCount = "select count(*) from quiz where section_id=" . $row['section_id'];
                $result = mysqli_query($conn, $sqlCount);
                $row1 = mysqli_fetch_assoc($result);
                $count = $row1["count(*)"];
                echo '<div class="col-lg-2"><p style="color:blue">' . $row['section_title'] . " ($count)" . '</p></div>';
            }
            ?>
        </div>
        <div class="row m-4">
            <div class="col-lg-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    I have voluntarily agreed to participate in the study and I fully understand that the results of the study will be used for development of mental health and wellness program for dads.
                    </label>
                </div>
            </div>
            <a class="btn btn-success" href="survey.php?section_id=1">Start survey</a>
        </div>
    </div>
</body>

</html>