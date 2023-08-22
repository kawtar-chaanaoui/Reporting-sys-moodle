<?php
require_once'page.php';
$categoryName = $_POST['catName'];
$assigNmbr = getAssignmentNmbrByCategoryName($categoryName);
$quizNmr = getQuizNmbrByCategoryName($categoryName);
$WorkshopNmr = getWorkshopNmbrByCategoryName($categoryName);
$dataPoints = array(
  array("label"=> "Devoirs", "y"=> $assigNmbr),
  array("label"=> "Tests", "y"=> $quizNmr),
  array("label"=> "Ateliers", "y"=> $WorkshopNmr),
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>System reporting moodle</title>
	<link rel="stylesheet" href="ResourcesProf.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
  <style>
   .DVS
   {
    padding: 12px;
    background: rgba(242, 242, 242, 0.2);
    color:white;
    margin: 30px; 
    width: 100%; 
    border: 2px solid #4360b5;
    border-radius: 15px;
    font-size: medium;
    text-indent: 10px;
   }
   .courses-container{
     padding: 36px;
     float: right;
     width:29%; 
     margin:5px;
     height: 370px;
     clear: right;
     background:#355cd1;
     border-radius: 10px;
   }
   
    

  </style>
</head>
<body>
  <div class="wrapper">
    <div class="top_navbar">
     <div class="hamburger">
     <div class="one"></div>
     <div class="two"></div>
     <div class="three"></div>
   </div>
      <div class="top_menu">
        <div class="logo">
          <img src="Logo1.png" alt=""> <p>Reports</p>   
        </div>
      </div>
    </div>
  
    <div class="sidebar">
      <ul>
        <li><a href="index.php">
          <span class="title"> <i class="fa fa-home"></i>Home</span>
        </a></li>

        <button class="dropdown-btn1"> Resources<i class="fa fa-caret-down"></i></button>
          <ul class="dropdown-container1">
            <li><a href="ResourcesGlobal.php">Global</a></li>
            <li><a href="ResourcesProf.php" >Professeurs</a></li>
            <li><a href="ResourcesCours.php">Cours</a></li>
            <li><a href="ResourcesCategories.php"class="active">Catégorie</a></li>
          </ul>
        <button class="dropdown-btn">Activité
          <i class="fa fa-caret-down"></i>
        </button>
        <ul class="dropdown-container">
        <li><a href="ActivitiesGlobal.php">Global</a></li>
        <li><a href="ActivitiesProf.php">Professeurs</a></li>
        <li><a href="ActivitiesCours.php">Cours</a></li>
        <li><a href="ActivitiesCategories.php">Catégorie</a></li>
        </ul>
      </ul>
    </div>
  
    <div class="main_container">
    <div class="courses-container">
         <h2 style="color:white;">Courses :</h2>
         <?php
         $tab=getCoursesByCategory(getCategoryId($categoryName));
         $th="DVS";
         foreach($tab as $v)
         {
          echo "<div class=".$th."> ".getCourseName($v)." </div>";
         } 
         ?>
       </div>
      <div class="" id="chartContainer" style="height: 370px; width: 70%;"></div> 
    </div>
  <script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;
    
    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
      } else {
      dropdownContent.style.display = "block";
      }
      });
    }
    /*chart drawing */
    window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer", {
     animationEnabled: true,
     exportEnabled: true,
     title:{
         text: <?php echo json_encode($categoryName, JSON_NUMERIC_CHECK); ?>
     },
     subtitles: [{
         text: " Activités"
     }],
     data: [{
         type: "pie",
         showInLegend: "true",
         legendText: "{label}",
         indexLabelFontSize: 16,
         indexLabel: "{label} - #percent%",
         yValueFormatString: "#,##0",
         dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
     }]
 });
 chart.render();
  
 }
    </script>
     <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>