<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" href="../icon.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <?php
    require('../connection.php');
        if(isset($_POST['submit']))
        {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $sql = "INSERT INTO `programs` (`program_id`, `title`, `description`) VALUES (NULL, '$title', '$description');";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                $last_id = mysqli_insert_id($conn);
                echo $last_id;
                $_SESSION["program_id"] = $last_id;

                header("location:createQuiz.php");
            }
        }
    ?>
</head>
<body>
    <div class="container">
        <div class="row">
        <h2>Create new Program</h2>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Program Title</label>
                <input type="text" class="form-control mt-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Program title" name="title">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Program Description</label>
                <input type="text" class="form-control mt-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Program description" name="description">
            </div>
            <input name="submit" type="submit" class="btn btn-primary mt-3"></button>
        </form>
        </div>
    </div>
</body>
</html>