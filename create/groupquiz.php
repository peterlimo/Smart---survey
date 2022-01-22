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
    if (isset($_POST['submit'])) {
        $program_id = 1;
        $quiz = $_POST['quiz'];
        $answerType = $_POST['answerType'];
        $group_id =  $_POST['group_id'];
        $section_id =$_POST['question_section'];
        $group_type= $_POST['group_type'];
        $sql = "INSERT INTO `quiz` (`quiz_id`,`section_id`,`program_id`,`group_id`,`quiz`, `type`, `group_type`) VALUES (NULL,'$section_id','$program_id','$group_id','$quiz','$answerType','$group_type');";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $last_id = mysqli_insert_id($conn);
            echo $last_id;
        }
        $counter = $_POST['counter'];
        $count = intval($counter);
        if ($answerType == "input") {
            echo "Your quiz for input type has been submitted successfully";
        } else {
            for ($x = 1; $x <= $count; $x++) {
                $val = $_POST['choice' . $x];
                $choiceInsert = "INSERT INTO `choices` (`id`, `quiz_id`, `choice`) VALUES (NULL, '$last_id','$val');";
                $choiceQuery = mysqli_query($conn, $choiceInsert);
                if ($choiceQuery) {
                    echo "Records inserted successfully";
                }
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
                        <a class="nav-link" href="fTogetherQuiz.php">Answer Quiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="statistics.php">Statistics</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="row">
        <div class="col-lg-2">
                <a href="checkbox.php">Check Box</a>
            </div>
            <div class="col-lg-2">
                <a href="radiobutton.php">Radio Buttons</a>
            </div>
            <div class="col-lg-2">
                <a href="normalinput.php">Normal Input</a>
            </div>
            <div class="col-lg-2">
                <a href="groupquiz.php">Group Question</a>
            </div>
            <div class="col-lg-2">
                <a href="createGroup.php">Create group</a>
            </div>
        </div>
        <div class="row">
            <h5>Normal Question</h5>
        </div>
        <form action="groupquiz.php" method="post">
            <span class="collapse" id="counter">0</span>
            <input class="collapse" type="number" name="counter" value="" id="counter1" />
            <div class="form-group mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <select class="form-select" name="group_id" aria-label="Default select example">
                            <option selected>Select question Group</option>
                            <?php
                            $sql = "Select * from quiz_group";
                            $sections = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_array($sections)) {
                                if($row['group_title']!="NA"){
                                echo '<option value="'. $row['group_id'].'">' .$row['group_title']. '</option>';
                            }
                        }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Question</label>
                <input type="text" class="form-control mt-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Question" name="quiz">
            </div>
            <div class="form-group mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <select class="form-select" name="question_section" aria-label="Default select example">
                            <option selected>Select question Gategory</option>
                            <?php
                            $sql = "Select * from sections";
                            $sections = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_array($sections)) {
                                echo '<h5>' . $row['section_title']. '</h5>';
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
            <div id="defaultanswertype">
                <div class="form-group mt-4" id="choose_answer_type">
                    <label for="exampleInputPassword1">Answer type</label><br>
                    <select name="answerType" class="form-select form-select-lg mb-3 mt-2" aria-label=".form-select-md example" id="aswerType">
                        <option selected>select type</option>
                        <option value="checkbox" id="multi-choice">MultiChoice(Checkbox)</option>
                        <option value="radio" id="single-choice">SingleChoice(Radio Buttons)</option>
                        <option value="input" id="input-box">Input box</option>
                    </select>
                </div>
            </div>

            <div class="form-group">

                <div class="row" obj>
                    <div class="col-lg-12" id="obj">
                    </div>
                </div>

            </div>

            <input name="submit" type="submit" class="btn btn-primary mt-3"></button>
        </form>
        <button class="btn-primary btn mt-3" id="Addnewbtn" onclick="addView()">Add new</button>
 
    </div>
</body>
<script>
    function remove() {
        var element = document.getElementById('obj');
        var counter = document.getElementById('counter').innerText;
        var inputC = document.getElementById('counter1');

        counter = parseInt(counter);
        counter = counter - 1;

        document.getElementById('counter').innerText = counter;
        inputC.setAttribute('value', counter);
    }
    $("#Addnewbtn").hide();

    $("select[name=answerType]").focus(function() {
        previous = this.value;
    }).change(function() {
        var next = $(this).val()
        if (next == "checkbox") {
            $("#Addnewbtn").show();
            $("#choiceForm").show();
        } else if (next == "radio") {
            $("#Addnewbtn").show();
            $("#choiceForm").show();
        } else {
            $("#Addnewbtn").hide();
            $("#obj").remove();
            document.getElementById('counter').innerText = 0;
            inputC.setAttribute('value', 0);
        }
        previous = this.value;
    });

    function addView() {
        var element = document.getElementById('obj');
        var counter = document.getElementById('counter').innerText;
        var inputC = document.getElementById('counter1');
        counter = parseInt(counter);
        counter = counter + 1;

        document.getElementById('counter').innerText = counter;


        var html = '<div class="col-lg-12">' +
            '<input type="text" id="objective"  placeholder="Choice' + counter + '"' +
            'class="form-control" autocomplete="objective" name="choice' + counter + '"' +
            '> <span class="text-red" onclick="remove()">remove</span>' +
            '</div>'
        inputC.setAttribute('value', counter);

        //  element.appendChild(html);
        $(document).ready(function() {

            $("#obj").append(html);

        });
    }


    function alertMe() {
        alert("clicked");
    }
</script>

</html>