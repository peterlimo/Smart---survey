<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Questionaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <?php
    require("../connection.php");
    $program_id = 1;
    if (isset($_POST['submit'])) {
        $section_id = $_POST['question_section'];
        $title = $_POST['group_title'];
        $answerType = "checkbox";
        $type = $_POST['group_type'];
        $sql = "INSERT INTO `quiz_group` (`group_id`, `section_id`,`group_title`, `group_type`) VALUES ('','$section_id','$title','$type');";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo "Group Created Successfully";
            $last_id = mysqli_insert_id($conn);
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
        <div class="col-lg-2">
                <a class="btn btn-primary" href="checkbox.php">Check Box</a>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-primary" href="radiobutton.php">Radio Buttons</a>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-primary" href="normalinput.php">Normal Input</a>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-primary" href="groupquiz.php">Group Question</a>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-primary" href="createGroup.php">Create group</a>
            </div>
        </div>
        <div class="row mt-5">
            <h5>Create a Question Group.</h5>
        </div>
        <form action="createGroup.php" method="post">
            <span class="collapse" id="counter">0</span>
            <input class="collapse" type="number" name="counter" value="" id="counter1" />
            <div class="form-group">
                <label for="exampleInputEmail1">Question</label>
                <input type="text" class="form-control mt-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Group Name Question" name="group_title">
            </div>
            <div class="form-group mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <select class="form-select" name="question_section" aria-label="Default select example">
                            <option selected>Select question Gategory</option>
                            <?php
                         
                            $sql = "Select * from sections";
                            $sections = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($sections)){
                                echo '<option value="'. $row['section_id'].'">' .$row['section_title']. '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Group Type</label>
                <select class="form-select" name="group_type">
                    <option value="normal">normal</option>
                    <option value="likert">likert</option>
                    <option value="mental">mental</option>
                </select>
            </div>

            <input name="submit" type="submit" class="btn btn-primary mt-3"></button>
        </form>
       
    </div>
</body>

</html>