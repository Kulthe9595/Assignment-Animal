<?php
include('connection.php');
// error_reporting(0);


if(isset($_POST['Submit'])){

    $animal_name = $_POST['animal-name'];
    $animal_description = $_POST['animal-description'];
    $category = $_POST['category'];
    $Life_expenctancy = $_POST['Life_expenctancy'];

    $captchaResult = $_POST["captchaResult"];
	$firstNumber = $_POST["firstNumber"];
	$secondNumber = $_POST["secondNumber"];
    
    // image upload 
        $fname = $_FILES['file']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

      // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
  
   
   

    if(in_array($imageFileType,$extensions_arr)){
        
        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$fname)){
    
            $sql = "INSERT INTO `animalcollection`(`name`, `category`, `animalimg`, `decription`, `life_expenctancy`,`uploaded`) VALUES ('$animal_name','$category','$fname','$animal_description','$Life_expenctancy',NOW())";
        
            $result = mysqli_query($conn,$sql);
               
            if($result){
                header("location:animals.php");
            }
        }
    }
        
   
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Animal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- MARKS: Heading -->
    <header class='speaker-form-header'>
      <h1>Add New Animal </h1>
    </header>
    <!-- ---------------- -->

    <!-- MARKS: Creating form -->

    <form method='POST' class='speaker-form' onsubmit="return validation()" enctype="multipart/form-data">
        <!-- Animal Name input filed -->
        <div class='form-row'>
            <label for='animal-name'>Animal Name</label>
            <input id='animal-name' id='animal-name' name='animal-name' type='text' />    
            <span id="animal_name_err" class="text-danger"> </span>
        </div>

        <!-- select category redio button -->
        <fieldset class='legacy-form-row'>
            <legend>Category</legend>
                <input type="radio"  id="category" name="category" value="Herbivores">
                <label  class='radio-label'>Herbivores</label>

                <input type="radio"  id="category" name="category" value="Omivores">
                <label  class='radio-label'>Omivores</label>
        
                <input type="radio" id="category" name="category" value="Carnivores">
                <label  class='radio-label'>Carnivores</label>

                <span id="category_err" class="text-danger"></span>
        </fieldset>

        <!-- upload image  -->
        <div class='form-row'>
            <label for='animal-image'>Upload Image</label> 
            <input name='file' type='file' id="file"/>
        </div>
        <span id="img_err" class="text-danger"></span>

        </div>

        <div class='form-row'>
            <label>Life Expectancy</label>
                <select  id="Life_expenctancy" name="Life_expenctancy">
                    <option value="0"> -- Select --</option>
                    <option value="0-1 Years"> 0-1 Years</option>
                    <option value="5-10 Years">5-10 Years</option>
                    <option value="10 + Years">10 + Years</option>
                </select>         
        </div>
        <span id="Life_expenctancy_err" class="text-danger"></span>
    
        <div class='form-row'>
                <label for='animal-description'>Description</label>
                <textarea id='animal-description' name='animal-description'></textarea>
        </div>

        <!-- 6)Captcha -->
        <div class='form-row'>
            <?php
            // captcha code
                $min_number = 1;
                $max_number = 15;

                $random_number1 = mt_rand($min_number, $max_number);
                $random_number2 = mt_rand($min_number, $max_number);
                ?><label><?php echo $random_number1 . ' + ' . $random_number2 . ' = ';?> </label> 
            <input type="text" id="captchaResult" name="captchaResult" value="">
            <input id="firstNumber" name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
            <input id="secondNumber" name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" />
        </div>
        <span id="captcha_err" class="text-danger"></span>


        <div class='form-row'>
            <input type="submit" name="Submit">
        </div>

    </form>
    <!-- -------------------- -->

</body>
<script type="text/javascript">

		function validation(){

			var animal_name = document.getElementById('animal-name').value;
            var Life_expenctancy = document.getElementById('Life_expenctancy').value;
            var animal_category = document.querySelector('input[name="category"]:checked');
            var fileInput =  document.getElementById('file').value;

            var captchaResult = document.getElementById('captchaResult').value;
            var firstNumber = document.getElementById('firstNumber').value;
            var secondNumber = document.getElementById('secondNumber').value;   

            var firstNumber1 = + firstNumber
            var secondNumber1 = + secondNumber
            var result = + captchaResult
            var total = firstNumber1 + secondNumber1
    
                document.getElementById('animal-name').innerHTML ="";
                document.getElementById('category_err').innerHTML ="";
                document.getElementById('Life_expenctancy_err').innerHTML ="";
                document.getElementById('img_err').innerHTML ="";
                document.getElementById('captcha_err').innerHTML ="";


            // Name error
			if(animal_name == ""){
				document.getElementById('animal_name_err').innerHTML =" ** Please fill the Animal Name field";
				return false;
			}
			if((animal_name.length <= 2) || (animal_name.length > 20)) {
				document.getElementById('animal_name_err').innerHTML =" ** Animal Name lenght must be between 2 and 20";
				return false;	
			}
			if(!isNaN(animal_name)){
				document.getElementById('animal_name_err').innerHTML =" ** only characters are allowed";
				return false;
			}


             // category error 
             if(!animal_category){
				document.getElementById('category_err').innerHTML =" ** Please One Of above Category ";
				return false;
            }

             // image error
             if(fileInput == ""){
				document.getElementById('img_err').innerHTML =" ** Please upload Correct file ";
				return false;
			}
            

            // Life_expenctancy error
            if(Life_expenctancy == "0"){
				document.getElementById('Life_expenctancy_err').innerHTML =" ** Please One Of above Life expenctancy";
				return false;
			}

            // Captcha  error
            if(result != total){
				document.getElementById('captcha_err').innerHTML =" ** Please enter correct captcha";
				return false;
			}
            
        }

	</script>
</html>
