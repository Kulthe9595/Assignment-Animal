<?php
include('connection.php');

// sorting
$order = '';
if(isset($_POST['sort'])){ 
  
  $sort = $_POST['sort'];
  
  if($sort == 'alpha'){
    $order = " ORDER BY `name` ASC";
  }else if($sort == 'new'){
    $order = " ORDER BY `uploaded` ASC";
  }else if($sort == 'old'){
    $order = " ORDER BY `uploaded` DESC";
  }
  
}

// Filter
$where = '';
if(isset($_POST['filter'])){

  if(!empty($_POST['category'])){
    $where .= " WHERE category IN(";
    $separtor = true;
    foreach($_POST['category'] as $row){
      if($separtor){
        $where .= "'" . $row . "'";
        $separtor = false;
        continue;
      }
      $where .= ", '" . $row . "'";
    }
    $where .= ") ";
  }
  if($_POST['Life_expenctancy'] != "0"){
    if(!empty($where)){
      $where .= " AND life_expenctancy = '".$_POST['Life_expenctancy']."' ";
    }else{
      $where .= " WHERE life_expenctancy = '".$_POST['Life_expenctancy']."' ";
    }
  }
}

$sql = "SELECT * FROM `animalcollection`" . $where . $order;
$search_result = filterTable($sql); 

// echo '<pre><li>Debug - Line no '.__LINE__.'</li><br />'; print_r($sql); echo '</pre><hr />'; exit;
function filterTable($sql){
      global $conn;
      $result = mysqli_query($conn, $sql);
      return $result;
    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals  </title>
    <link href="style.css" rel="stylesheet">
    <style>
      .mytable ,th,td{
        border: 1px solid black;
        border-collapse: collapse;
        padding: 7px;
        font-weight: bold;
        max-width : 600px;
      }
    </style>
  </head>
  <body>
    <!-- ---------------- -->
  
   <form method="POST" class='speaker-form' id = "sortform">
     <!-- select category redio button -->

     <fieldset class='legacy-form-row'>
            <legend>Sort</legend>
                <input type="radio" onclick="doSortFilter()" name="sort" value="alpha" <?php echo (!empty($_POST['sort']) && $_POST['sort'] == 'alpha') ? 'checked' : ''; ?> >
                <label  class='radio-label'>Alphabetically</label>

                <input type="radio" name="sort" onclick="doSortFilter()" value="new" <?php echo (!empty($_POST['sort']) && $_POST['sort'] == 'new') ? 'checked' : ''; ?> >
                <label  class='radio-label'>Newest</label>
        
                <input type="radio" name="sort" onclick="doSortFilter()" value="old" <?php echo (!empty($_POST['sort']) && $_POST['sort'] == 'old') ? 'checked' : ''; ?> >
                <label  class='radio-label'>Oldest</label>

        </fieldset>
     <fieldset class='legacy-form-row'>
            <legend>Filter</legend>
                <input type="Checkbox"   id="category" name="category[]" value="Herbivores"  <?php echo (!empty($_POST['category']) && in_array('Herbivores', $_POST['category']) ) ? 'checked' : ''; ?> >
                <label  class='radio-label'>Herbivores</label>

                <input type="Checkbox"  id="category" name="category[]" value="Omivores"<?php echo (!empty($_POST['category']) && in_array('Omivores', $_POST['category']) ) ? 'checked' : ''; ?> >
                <label  class='radio-label'>Omivores</label>
        
                <input type="Checkbox" id="category" name="category[]" value="Carnivores"<?php echo (!empty($_POST['category']) && in_array('Carnivores', $_POST['category']) ) ? 'checked' : ''; ?> >
                <label  class='radio-label'>Carnivores</label>

        </fieldset>
        <div class='form-row'>
            <label>Life Expectancy</label>
                <select  id="Life_expenctancy" name="Life_expenctancy">
                    <option value="0"> -- Select --</option>
                    <option value="0-1 Years"> 0-1 Years</option>
                    <option value="5-10 Years">5-10 Years</option>
                    <option value="10 + Years">10 + Years</option>
                </select>         
        </div>
        <div class='form-row'>
            <input type="submit" name="filter" value="Filter">
        </div>
        <div class='form-row'>
            <a href ="index.php">Add New </a>
        </div>
   </form>


       <table class="mytable">
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

            $sr_no = 1;
        

            if($search_result->num_rows > 0){
              while($row = mysqli_fetch_array($search_result)){
                $image = $row['animalimg'];
                $image_src = "upload/".$image;
            

          ?>
          <tr>
            <td><?php echo $sr_no; ?></td>
            <td><img src='<?php echo $image_src; ?>' width="100px" height="100px"></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['category'];?></td>
            <td><?php echo $row['decription'];?></td>
            <td><?php echo $row['life_expenctancy'];?></td>
        <?php
          $sr_no++;
        }
      }else{
        ?>
        <td colspan="6" style="color: red; text-align:center; font-weight:bolder;">No result found</td>
        </tr>
        <?php
      }
        ?>
        </tbody>
      </table>
  </body>
  <script>
    
    
    function doSortFilter(){
       document.getElementById('sortform').submit();   
    }
  </script>
</html>
