<?php
include('connection.php');
error_reporting(0);

$err_name = $err_category= $err_decription = $err_img = $errlife_exp =$err_captcha =  '';

if(isset($_POST['Submit'])){

   
    $animalName = $_POST['animalName'];
    $description = $_POST['Description'];
    $category = $_POST['category'];
    $lifeExpenctancy = $_POST['LifeExpenctancy'];

    $captchaResult = $_POST["captchaResult"];
	$firstNumber = $_POST["firstNumber"];
	$secondNumber = $_POST["secondNumber"];


    $checkTotal = $firstNumber + $secondNumber;
    
    // upload img 

     // Get file info 
     $fileName = basename($_FILES["image"]["name"]); 
     $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
    
     // Allow certain file formats 
     $allowTypes = array('jpg','png','jpeg','gif'); 
        

        if(empty(trim($animalName))){
            $err_name = "Enter Animal Name!";
        }
           
        if(empty(trim($description))){
            $err_decription = "Enter description!";
        } 
        if(empty($category)){
             $err_category = "Please Select Category";

         }  
        if(empty($lifeExpenctancy)){
            $errlife_exp = "Please Select Life Expenctancy";
        }         
        if(empty($_FILES["image"]["name"])){
            $err_img ="Please Select Image";
        }

        if ($captchaResult != $checkTotal) {
            $err_captcha = "You Enter Wrong Captcha code!";
        }
         


            
        if(!empty($animalName) && !empty($description) && !empty($category) && !empty($lifeExpenctancy) && !empty($captchaResult)&& in_array($fileType, $allowTypes)){ 

                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
        
               $sql = "INSERT INTO `animalcollection`(`name`, `category`, `animalimg`, `decription`, `life_expenctancy`,`uploded`) VALUES ('$animalName','$category','$imgContent','$description','$lifeExpenctancy',NOW())";
        
                $result = mysqli_query($conn,$sql);
            
                if($result){
                    header("location:animals.php");
                }
            }
}


?>

<html>  
    <head>  
        <title>Animal</title>  
  <link rel="stylesheet" type="text/css" href="CSS/style.css">
    </head>  
    <body>  
 <div class="container" style="width: 600px">
  

   <h3 align="center"> Add New Animal</a></h3><br />

  
      <h3>Enter details</h3>
  
     
     
    <form method="POST" enctype="multipart/form-data">

      
       <label>Name of Animal <span class="text-danger">*</span></label>
       <input type="text" name="animalName"  />
       <span id="name_Error" class="text-danger"> <?php if(!empty($err_name)){  echo $err_name;}?></span><br>
     

      
        <label for="Select_Category">Select Category <span class="text-danger">*</span></label><br><br>
            <input type="radio"  name="category" value="Herbivores">
            <label>Herbivores</label>

            <input type="radio"  name="category" value="Omivores">
            <label>Omivores</label>
        
            <input type="radio" name="category" value="Carnivores">
            <label>Carnivores</label>
        
            <span id="error_category" class="text-danger"> <?php if(!empty($err_category)){  echo $err_category;}?></span><br><br>
       



       
            <label for="image">Upload Image<span class="text-danger">*</span></label><br>
            <input type="file"  name="image">
            <span id="img_error" class="text-danger"> <?php if(!empty($err_img)){  echo $err_img;}?></span><br>
  <label>Description</label><br>
        <textarea  name="Description" rows="3"></textarea>
        <span id="error_desc" class="text-danger"> <?php if(!empty($err_decription)){  echo $err_decription;}?></span><br>
       

       
        <label>Life Expectancy <span class="text-danger">*</span></label><br>
        <select  name="LifeExpenctancy">
            <option> -- Select --</option>
            <option value="0-1 Years"> 0-1 Years</option>
            <option value="5-10 Years">5-10 Years</option>
            <option value="10+ Years">10+ Years</option>
        </select>
        <span id="error_lifeexp" class="text-danger"> <?php if(!empty($errlife_exp)){  echo $errlife_exp;}?></span><br>
       

        <!-- 6)Captcha -->
    <?php
    // captcha code
        $min_number = 1;
        $max_number = 15;

        $random_number1 = mt_rand($min_number, $max_number);
        $random_number2 = mt_rand($min_number, $max_number);
        echo $random_number1 . ' + ' . $random_number2 . ' = <br>';
    ?>  
        <input type="text"  name="captchaResult"><br>
        <input name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
        <input name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" /><br>
        <?php if(!empty($err_captcha)){?> <p class="text-danger"><?php echo $err_captcha;}?></p>
 

      
       <input type="submit" name="Submit"  />
 </div>
     </form>
     
   
    </body>  
</html>
