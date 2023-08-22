<?php
require 'page.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>System reporting moodle</title>
	<link rel="stylesheet" href="styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
  <style>
   .DVS
   {
    padding: 12px;
    background: rgba(179, 198, 255, 0.2);
    color:black;
    margin: 30px; 
    width: 70%; 
    border: 2px solid #4360b5;
    border-radius: 15px;
    font-size: medium;
    text-indent: 10px;
   }
   .courses-container{
     padding: 36px;
     
     width:50%; 
     margin:5px;
     height: 370px;
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
          <img src="Logo1.png" alt=""> <p>Repots</p> 
            
        </div>
      </div>
    </div>
  
    <div class="sidebar">
      <ul>
        <li><a href="index.php" class =" active">
          <span class="title"> <i class="fa fa-home" style="clear:left"></i>Home</span>
        </a></li>
         <button class="dropdown-btn"> Resources<i class="fa fa-caret-down"></i></button>
          <ul class="dropdown-container">
            <li><a href="ResourcesGlobal.php">Global</a></li>
            <li><a href="ResourcesProf.php">Professeurs</a></li>
            <li><a href="ResourcesCours.php">Cours</a></li>
            <li><a href=" ResourcesCategories.php">Catégorie</a></li>
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
         <div class="DVS">  nombre des categories est<?php echo " : ".getcategoryNmr()."";?></div>
         <div class="DVS">  nombre des cours<?php echo " : ".getcourseNmr()."";?></div>
         <div class="DVS">  nombre des Utilisateurs<?php echo " : ".getUsersNmr()."";?></div>


        </div>
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
    </script>
    
</body>
</html>