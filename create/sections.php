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

        $counter = $_POST['counter'];
        $count = intval($counter);
     
            for ($x = 1; $x <= $count; $x++) {
                $val = $_POST['section' . $x];
                $choiceInsert = "INSERT INTO `sections` (`section_id`, `program_id`, `section_title`) VALUES (NULL, '$program_id','$val');";
                $choiceQuery = mysqli_query($conn, $choiceInsert);
                if ($choiceQuery) {
                    echo "Records inserted successfully";
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
            <h5>Normal Question</h5>
        </div>
        <form action="sections.php" method="post">
            <span class="collapse" id="counter">0</span>
            <input class="collapse" type="number" name="counter" value="" id="counter1" />
            <div class="form-group">
                <label for="exampleInputEmail1">Question</label>
             </div>


            <div class="form-group">

                <div class="row">
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
            '<input type="text" id="objective"  placeholder="Section' + counter + '"' +
            'class="form-control" autocomplete="objective" name="section' + counter + '"' +
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