<?php
include('connection.php');

     $sql="SELECT * FROM `animalcollection`";
    $search_result = filterTable($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals  </title>
    <link href="CSS/style1.css" rel="stylesheet">
  </head>
  <body>
  
    <div id="main" >
      <div class="counter">
             <a href="submission.php" class="btn success"> Add New </a>
             <button type="button" class="btn info">Visitors <span> <?php echo $counter; ?></span></button>
    </div>
    <form method="POST">
   <label for="sort">Sort by Alphabetically</label>
   <button type="submit" name="sortbtn" class="btn1" >A-Z</button>
    <button type="submit" name="sortbtn1" class="btn1" >Z-A</button>


    <label for="sort">Sort by Date</label>
      <input type="Date" name="sortbtn2">
    <button type="submit" name="sortbtn3" class="btn1">Sort</button>

    <label>Sort by category</label>
    <select name="sort">
      <option value="Herbivores"> Herbivores</option>
       <option value="Omivores">Omivores</option>
        <option value="Carnivores">Carnivores</option>
    </select>
    <button type="submit"  name="sortbtn4" class="btn1">Sort</button>
    <label>Sort by Lifespan</label>
    <select name="sortlife">
       <option value="0-1 Years"> 0-1 Years</option>
            <option value="5-10 Years">5-10 Years</option>
            <option value="10+ Years">10+ Years</option>
    </select>
    <button type="submit"  name="sortbtn5" class="btn1">Sort</button>
</form>





       <table class="content-table" border="1px">
        <thead>
          <tr>
            <th>Sr No</th>
            <th>Image</th>
            <th>Name </th>
            <th>Category </th>
            <th>Description</th>
            <th>Life Expectancy </th>
          </tr>
        </thead>
        <tbody>
          <?php
 if( isset($_POST['sortbtn'])){
    
     $sql="SELECT * FROM `animalcollection` ORDER BY `animalcollection`.`name`,`id` ASC";
     $search_result = filterTable($sql);
    }
    if( isset($_POST['sortbtn1'])){
 
      $sql1="SELECT * FROM `animalcollection` ORDER BY `animalcollection`.`name` DESC";
      $search_result = filterTable($sql1);
    }
 if( isset($_POST['sortbtn3'])){
      $sortdate=$_POST['sortbtn2'];

      $sql="SELECT * FROM `animalcollection` WHERE `uploded` ='$sortdate'";
      $search_result = filterTable($sql);
    }
    if( isset($_POST['sortbtn4'])){
      $sortcat=$_POST['sort'];

      $sql2="SELECT * FROM `animalcollection` WHERE `category` ='$sortcat'";
      $search_result = filterTable($sql2);
    }
     if( isset($_POST['sortbtn5'])){
      $sortlife=$_POST['sortlife'];

      $sql3="SELECT * FROM `animalcollection` WHERE `life_expenctancy` ='$sortlife'";
      $search_result = filterTable($sql3);
    }
    function filterTable($sql){
        global $conn;
        // $conn = mysqli_connect("localhost","root"," ","timepassdatabase");
        $result = mysqli_query($conn, $sql);
        return $result;
    }
$sr_no = 1;

while($row = mysqli_fetch_array($search_result)){
?>
          <tr>
            <td>
              <?php echo $sr_no; ?> 
            </td>
            <td>
              <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['animalimg']); ?>" width="100px" height="100px" />
            </td>
            <td>
              <?php echo $row['name'];?>
            </td>
            <td>
              <?php echo $row['category'];?>
            </td>
            <td>
              <?php echo $row['decription'];?>
            </td>
            <td>
              <?php echo $row['life_expenctancy'];?>
            </td>
          </tr>
          <?php
$sr_no++;
}
// }
?>
        </tbody>
      </table>
    </div>
    
  </body>
</html>
