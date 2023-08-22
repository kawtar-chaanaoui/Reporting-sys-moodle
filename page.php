<?php

  function connect()
  {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "moodle";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) 
    {
      die("Connection failed: " . $conn->connect_error);
    }

    return $conn;

  }
  //--------------------------------------------------------------------------------------------------------
  
  function getFilesNumbrByCoursName($coursName)
  {
    $conn = connect();

    $sql = "SELECT COUNT(*) as total
            FROM mdl_resource
            WHERE course = (SELECT id
                            FROM   mdl_course
                            WHERE fullname = '" . $coursName . "')";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())

    return $row["total"];    
  }
  function getFilesNumbrByCoursId($coursId)
  {
    $conn = connect();

    $sql = "SELECT COUNT(*) as total
            FROM mdl_resource
            WHERE course = (SELECT id
                            FROM   mdl_course
                            WHERE id = " . $coursId . ")";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())
    return $row["total"];    
    
  }

  function getFilesNumbrByProfId($profId)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByProf($profId);

    foreach ($table as $var)
    {
      $count += getFilesNumbrByCoursId($var);
    }

    return $count;
  }
  function getFilesNumbrByProfName($profName)
  {
    return getFilesNumbrByProfId(getProfId($profName));
  }
  function getFilesNumbrByCategoryName($categoryName)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByCategory(getCategoryId($categoryName));

    foreach ($table as $var)
    {
      $count += getFilesNumbrByCoursId($var);
    }

    return $count;
  }
  //--------------------------------------------------------------------------------------------------------
  function getBooksNumbrByCoursName($coursName)
  {
    $conn = connect();

    $sql = "SELECT COUNT(*) as total
            FROM mdl_book
            WHERE course = (SELECT id
                            FROM   mdl_course
                            WHERE fullname = '" . $coursName . "')";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())
    return $row["total"];    
  }
  function getBooksNumbrByCoursId($coursId)
  {
    $conn = connect();

    $sql = "SELECT COUNT(*) as total
            FROM mdl_book
            WHERE course = (SELECT id
                            FROM   mdl_course
                            WHERE id = '" . $coursId . "')";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())
    return $row["total"];    
  }
  function getBooksNumbrByProfId($profId)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByProf($profId);

    foreach ($table as $var)
    {
      $count += getBooksNumbrByCoursId($var);
    }

    return $count;
  }
  function getBooksNumbrByProfName($profName)
  {
    return getBooksNumbrByProfId(getProfId($profName));
  }
  function getBooksNumbrByCategoryName($categoryName)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByCategory(getCategoryId($categoryName));

    foreach ($table as $var)
    {
      $count += getBooksNumbrByCoursId($var);
    }

    return $count;
  }
  //--------------------------------------------------------------------------------------------------------
  function getURLsNumbrByCoursName($coursName)
  {
    $conn = connect();

    $sql = "SELECT COUNT(*) as total
            FROM mdl_url
            WHERE course = (SELECT id
                            FROM   mdl_course
                            WHERE fullname = '" . $coursName . "')";

    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc())
    return $row["total"];    
  }
  function getURLsNumbrByCoursId($coursId)
  {
    $conn = connect();

    $sql = "SELECT COUNT(*) as total
            FROM mdl_url
            WHERE course = (SELECT id
                            FROM   mdl_course
                            WHERE id = '" . $coursId . "')";

    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc())
    return $row["total"];    
  }
  function getURLsNumbrByProfId($profId)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByProf($profId);

    foreach ($table as $var)
    {
      $count += getURLsNumbrByCoursId($var);
    }

    return $count;
  }
  function getURLsNumbrByProfName($profName)
  {
    return getURLsNumbrByProfId(getProfId($profName));
  }
  function getURLsNumbrByCategoryName($categoryName)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByCategory(getCategoryId($categoryName));

    foreach ($table as $var)
    {
      $count += getURLsNumbrByCoursId($var);
    }

    return $count;
  }
  //--------------------------------------------------------------------------------------------------------  
  //--------------------------- USEFUL FUNCTIONS----------------------------------------------------------------------  
  function getCoursesByProf($userId)
  {
    $tableOfCourses = [];
    $i = 0;

    $conn = connect();
    // we select the contextid where roleid=3 wich means prof .and userud equal the userId passed in parameter
    $sql = "select contextid from mdl_role_assignments where roleid=3 and userid=" . $userId;
    $res = $conn->query($sql);

    while ($row = $res->fetch_assoc()) 
    {
      $contextid = $row["contextid"];

      // we try to find the instanceid using the contextid from the previous query and contextlever=50 means it's a course
      $sql1 = "select instanceid from mdl_context where id=".$contextid." and contextlevel=50";
      $res1 = $conn->query($sql1);
      while($row1 = $res1->fetch_assoc())
      {
        $instanceid = $row1["instanceid"];
      }
      // we are using the previous instanceid to get the info of the course
      $sql2 = "select id,shortname,fullname from mdl_course where id=$instanceid";
      $res2 = $conn->query($sql2);
      while($row2 = $res2->fetch_assoc())
      {
        $tableOfCourses[$i] =  $row2["id"] ;
        $i++;
      }
    }

    $conn->close();

    return $tableOfCourses;
  }
  
  function getCoursesByCategory($categoryId)
  {
    $tableOfCourses = [];
    $i = 0;

    $conn = connect();
    $sql = "select id from mdl_course where category=" . $categoryId;
    $res = $conn->query($sql);
    while($row = $res->fetch_assoc())
    {
      $tableOfCourses[$i] =  $row["id"];
      $i++;
    }

    return $tableOfCourses;
  }
  function getProfId($fullname)
  {
    $tb = splitname($fullname);
    $conn = connect();
    $sql = "select id 
            from mdl_user
            where firstname = '" .$tb[0]. "'
            and lastname = '" .$tb[1]. "'
            ";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) 
    {
      return $row["id"];
    }
  }
  function getCourseId($coursName)
  {
    $conn = connect();
    $sql = "select id from mdl_course where fullname= '" . $coursName . "'";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) 
    {
      return $row["id"];
    }
  }

  function getCourseName($coursId)
  {
    $conn = connect();
    $sql = "select fullname from mdl_course where id= '" . $coursId . "'";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) 
    {
      return $row["fullname"];
    }
  }
  function getActivitiesByCoursId($coursId)
  {
    $conn = connect();
    $sql = "SELECT Count(*) as total
            FROM mdl_grade_items
            WHERE categoryid IS NOT NULL
            AND itemmodule = 'quiz'
            AND courseid = ". $coursId;

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    return $row["total"]; 
  }
  function getCategoryId($categoryName)
  {
    $conn = connect();
    $sql = "select id from mdl_course_categories where name= '" . $categoryName . "'";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) 
    {
      return $row["id"];
    }
  }

  //--------------------------------------------------------------------------------------------------------  
  function getAssignmentNmbrByCoursName($coursName)
  {
    $conn = connect();
    $coursId = getCourseId($coursName);

    $sql = "SELECT Count(*) as total
            FROM mdl_grade_items
            WHERE categoryid IS NOT NULL
            AND itemmodule = 'assign'
            AND courseid = ". $coursId;

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    return $row["total"]; 
  }
  function getAssignmentNmbrByCoursId($coursId)
  {
    $conn = connect();
    $sql = "SELECT Count(*) as total
            FROM mdl_grade_items
            WHERE categoryid IS NOT NULL
            AND itemmodule = 'assign'
            AND courseid = ". $coursId;

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    return $row["total"]; 
  }
  function getAssignmentNmbrByProfName($profName)
  {
    $conn = connect();
    $count = 0;
    $profId = getProfId($profName);
    $table = getCoursesByProf($profId);

    foreach ($table as $var)
    {
      $count += getAssignmentNmbrByCoursId($var);
    }
    return $count;
  }
  function getAssignmentNmbrByCategoryName($categoryName)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByCategory(getCategoryId($categoryName));

    foreach ($table as $var)
    {
      $count += getAssignmentNmbrByCoursId($var);
    }

    return $count;
  }
  //--------------------------------------------------------------------------------------------------------  
  function getQuizNmbrByCourseName($coursName)
  {
    $conn = connect();
    $coursId = getCourseId($coursName);

    $sql = "SELECT Count(*) as total
            FROM mdl_grade_items
            WHERE categoryid IS NOT NULL
            AND itemmodule = 'quiz'
            AND courseid = ". $coursId;

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    return $row["total"]; 
  }
  function getQuizNmbrByCourseId($coursId)
  {
    $conn = connect();
    $sql = "SELECT Count(*) as total
            FROM mdl_grade_items
            WHERE categoryid IS NOT NULL
            AND itemmodule = 'quiz'
            AND courseid = ". $coursId;

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    return $row["total"]; 
  }
  function getQuizNmbrByProfName($profName)
  {
    $conn = connect();
    $count = 0;
    $profId = getProfId($profName);
    $table = getCoursesByProf($profId);

    foreach ($table as $var)
    {
      $count += getQuizNmbrByCourseId($var);
    }
    return $count;
  }
  function getQuizNmbrByCategoryName($categoryName)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByCategory(getCategoryId($categoryName));

    foreach ($table as $var)
    {
      $count += getQuizNmbrByCourseId($var);
    }

    return $count;
  }
  //--------------------------------------------------------------------------------------------------------  
  function getWorkshopNmbrByCourseName($coursName)
  {
    $conn = connect();
    $coursId = getCourseId($coursName);

    $sql = "SELECT Count(*) as total
            FROM mdl_grade_items
            WHERE categoryid IS NOT NULL
            AND itemmodule = 'workshop'
            AND courseid = ". $coursId;

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    return $row["total"]; 
  }
  function getWorkshopNmbrByCourseId($coursId)
  {
    $conn = connect();
    $sql = "SELECT Count(*) as total
            FROM mdl_grade_items
            WHERE categoryid IS NOT NULL
            AND itemmodule = 'workshop'
            AND courseid = ". $coursId;

    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    return $row["total"]; 
  }
  function getWorkshopNmbrByProfName($profName)
  {
    $conn = connect();
    $count = 0;
    $profId = getProfId($profName);
    $table = getCoursesByProf($profId);

    foreach ($table as $var)
    {
      $count += getWorkshopNmbrByCourseId($var);
    }
    return $count;
  }
  function getWorkshopNmbrByCategoryName($categoryName)
  {
    $conn = connect();
    $count = 0;
    $table = getCoursesByCategory(getCategoryId($categoryName));

    foreach ($table as $var)
    {
      $count += getWorkshopNmbrByCourseId($var);
    }

    return $count;
  }
  function getproflist()
  {
    $table = [];
    $conn = connect();
    $i = 0;

    $sql = "SELECT userid 
            FROM mdl_role_assignments
            WHERE roleid = 3";

    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())
    {
      $sql1 = "SELECT firstname ,lastname
               FROM mdl_user
               WHERE id=" . $row["userid"] ;
      $result1 = $conn->query($sql1); 
      while($row1 = $result1->fetch_assoc())
      {
        $table[$i] = $row1["firstname"] . "," . $row1["lastname"];
        $i++;
      }
      
    }
    $table = array_unique($table);
    return $table;
  }
  function getcourslist()
  {
    $table = [];
    $conn = connect();
    $i = 0;
    $sql = "SELECT fullname
            FROM mdl_course 
            WHERE id>= 2";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
      {
        $table[$i] = $row["fullname"];
        $i++;
      }
    return $table;
  }
  function removeColom($text)
  {
    $table = explode("," ,$text);
    $r = "";
    foreach ($table as $var)
      $r = $r . " " . $var;

    return $r;
  }
  function splitname($fullname)
  {
    $table = explode("," , $fullname);
    return $table;
  }
  function getcategorylist()
  {
    $table = [];
    $conn = connect();
    $i = 0;
    $sql = "SELECT name
            FROM mdl_course_categories";
    
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
      {
        $table[$i] = $row["name"];
        $i++;
      }
    return $table;
  }
  function getcategoryNmr()
  {
    $conn = connect();
    $sql = "SELECT Count(*) as total
            FROM mdl_course_categories";
    
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())

    return $row["total"]; 
    
  }
  function getcourseNmr()
  {
    $conn = connect();
    $sql = "SELECT Count(*) as total
            FROM mdl_course
            where id>= 2";
    
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())

    return $row["total"]; 
    
  }
  function getUsersNmr()
  {
    $conn = connect();
    $sql = "SELECT Count(*) as total
    FROM mdl_user 
    where id>= 2";
  
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc())

    return $row["total"];
  }
  //--------------------------------------------------------------------------------------------------------  
  //DONE    
    
?>