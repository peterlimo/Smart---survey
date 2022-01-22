<?php
session_start();
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
    ?>
</head>

<body>
    <div class="container">


    <div class="accordion accordion-flush" id="accordionFlushExample">
            <?php
            $my_section_id  = $_GET['section_id'];
            $groupSql = "select * from quiz_group";
            $qQuery = mysqli_query($conn,$groupSql); 

            while($row1 = mysqli_fetch_array($qQuery))
            {
                if($row1['section_id'] == $my_section_id){
                        
                    echo $row1['group_title'];
                }
                if($row1['group_type'] =="likert" && $row1['section_id'] == $my_section_id)
                {
                   
                    $getQ ="select * from quiz where group_id =".$row1['group_id']." and section_id=".$my_section_id;
                    $gg1 = mysqli_query($conn,$getQ);

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
                    while($rowQ = mysqli_fetch_assoc($gg1))
                        {
                        
                            echo '<tr>
                            <th style="width:100px;font-size:14px;" scope="row">'.$rowQ['quiz'].'</th>
                            ';
                            $radioData = "select * from choices where quiz_id=" . $rowQ['quiz_id'];
                            $radioQ = mysqli_query($conn, $radioData);
                            if (mysqli_num_rows($radioQ) > 0) {
                                echo '<div class="likert_list"><ul>';
                                while ($rowRadio = mysqli_fetch_array($radioQ)) {
                                    $lSql ="select * from answers where answer=".$rowRadio['id'];
                                    $qlSl =mysqli_query($conn,$lSql);
                                    $total =mysqli_num_rows($qlSl);

                                    echo '<td align="center" id='.$rowRadio['id'].' style="text-align:center;margin:auto">'.$total.' </td>';    
                               
                                }
                                echo '</ul></div>';
                            }
                           echo '
                          </tr>';
                        }
                        echo '</tbody></table>';
                    echo "</div>";

                }

else  if($row1['group_type'] =="mental" && $row1['section_id'] == $my_section_id)
{
    if($row1['group_title']!="NA" && $row1['section_id'] == $my_section_id){
        
        echo $row1['group_title'];
    }
    $getQ ="select * from quiz where group_id =".$row1['group_id']." and section_id=".$my_section_id;
    $gg1 = mysqli_query($conn,$getQ);

    echo '<div class="shadow-md bg-white quiz_div mt-2" style="border-radius:8px;">';
    echo '<table  class="table table-striped">
    <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Not At All</th>
      <th scope="col">Several Days</th>
      <th scope="col">More than half the days</th>
      <th scope="col">Nearly Every Day</th>
    </tr>
  </thead>
  <tbody>
    ';
    while($rowQ = mysqli_fetch_assoc($gg1))
        {
        
            echo '<tr>
            <th style="width:100px;font-size:14px;" scope="row">'.$rowQ['quiz'].'</th>
            ';
            $radioData = "select * from choices where quiz_id=" . $rowQ['quiz_id'];
            $radioQ = mysqli_query($conn, $radioData);
            if (mysqli_num_rows($radioQ) > 0) {
                echo '<div class="likert_list"><ul>';
                while ($rowRadio = mysqli_fetch_array($radioQ)) {
                    $lSql ="select * from answers where answer=".$rowRadio['id'];
                    $qlSl =mysqli_query($conn,$lSql);
                    $total =mysqli_num_rows($qlSl);

                    echo '<td align="center" id='.$rowRadio['id'].' style="text-align:center;margin:auto">'.$total.' </td>';    
               
                }
                echo '</ul></div>';
            }
           echo '
          </tr>';
        }
        echo '</tbody></table>';
    echo "</div>";

}



else if($row1['group_type']=="location" && $row1['section_id'] == $my_section_id)
{
    $countySql = "select * from counties";
    $countyQuery = mysqli_query($conn,$countySql);
    while($countyRows = mysqli_fetch_assoc($countyQuery))
    {
        $cSql ="select * from answers where answer=".$countyRows['name'];
        $qSl =mysqli_query($conn,$cSql);
        $total =mysqli_num_rows($qSl);
        echo $countyRows['name']. "" .$total;
    }
    
}





                else{
                    if($row1['group_title']!="NA" && $row1['section_id'] == $my_section_id){
                        echo '<div class="mt-2"><h5 style="color:#202124;font-weight: 400;font-family:Roboto">'.$row['group_title'].'</h5></div>';
                        }
                $getQ ="select * from quiz where group_id =".$row1['group_id']." and section_id=".$my_section_id;
                $gg = mysqli_query($conn,$getQ);
                while($row = mysqli_fetch_assoc($gg))
                {
                    echo '<div class="accordion-item">'.
                    '<h2 class="accordion-header" id="flush-headingTwo">'.
                        '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo'.$row['quiz_id'].'" aria-expanded="false" aria-controls="flush-collapseTwo'.$row['quiz_id'].'">'.
                         $row['quiz']
                        .'</button>'.
                    '</h2>'.
                    '<div id="flush-collapseTwo'.$row['quiz_id'].'" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">';
                  
                    if( $row['type'] == "input"){
                        $inputChoiceId="NA";
                        $sqlInputAnswers ="select * from answers where quiz_id=".$row['quiz_id'];
                        $inputQuery = mysqli_query($conn, $sqlInputAnswers);
                        while($inputRow = mysqli_fetch_array($inputQuery))
                        {
                            echo '<div class="accordion-body">'.$inputRow['answer'].'</div>';
                        }
                        }
                        else if ($row['type'] == "radio") 
                        {
                            $radioData = "select * from choices where quiz_id=" . $row['quiz_id'];
                            $radioQ = mysqli_query($conn, $radioData);
                            if (mysqli_num_rows($radioQ) > 0) {
                         
                                while ($rowRadio = mysqli_fetch_array($radioQ)) {
                                    if($rowRadio['choice'] == "Other")
                                    {
                                        echo '<div class="radioholder m-1" style="margin-left:100px;">
                                        <label for='.$rowRadio['id'].'>Other(Specify)</label>
                                        </div>';
                                        $oSql ="select * from answers where choice!=".$rowRadio['id'];
                                        $oSl =mysqli_query($conn,$cSql);
                                        while($row2 = mysqli_fetch_assoc($oSl))
                                        {
                                            echo "Responses for other";
                                        }
                                    }
                                    else{
                                        $cSql ="select * from answers where answer=".$rowRadio['id'];
                                        $qSl =mysqli_query($conn,$cSql);
                                        $total =mysqli_num_rows($qSl);

                                       
                                    echo '<div class="radioholder m-1">
                                    <label id="optionId" for='.$rowRadio['id'].' style="margin-left:10px; width:70%">' . ' ' . $rowRadio['choice'] . '<br>
                                    </label>'.$total.'</div>';
                                }
                            }
                            }
       
                            // .$radioRow['choice_id']
                        }

                        else if ($row['type'] == "radio" && $row['group_type'] == "normal") {

                            $radioData = "select * from choices where quiz_id=" . $row['quiz_id'];
                            $radioQ = mysqli_query($conn, $radioData);
                            if (mysqli_num_rows($radioQ) > 0) {
                         
                                while ($rowRadio = mysqli_fetch_array($radioQ)) {
                                    if($rowRadio['choice'] == "Other")
                                    {
                                        echo '<div class="radioholder m-1" style="margin-left:100px;">
                                        <label for='.$rowRadio['id'].'>Other(Specify)</label>
                                        </div>';
                                        $oSql ="select * from answers where choice!=".$rowRadio['id'];
                                        $oSl =mysqli_query($conn,$cSql);
                                        while($row2 = mysqli_fetch_assoc($oSl))
                                        {
                                            echo "Responses for other";
                                        }
                                    }
                                    else{
                                        $cSql ="select * from answers where answer=".$rowRadio['id'];
                                        $qSl =mysqli_query($conn,$cSql);
                                        $total =mysqli_num_rows($qSl);

                                       
                                    echo '<div class="radioholder m-1">
                                    <label id="optionId" for='.$rowRadio['id'].' style="margin-left:10px; width:70%">' . ' ' . $rowRadio['choice'] . '<br>
                                    </label>'.$total.'</div>';
                                }
                            }
                            }
                        }
                    echo '</div>'.
                    '</div>';
                }

                }


            }
           
            ?>
        </div>
    </div>
</body>

</html>