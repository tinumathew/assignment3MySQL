<!DOCTYPE html>
<html>
    <head>
        <title>Company Registration</title>
        <link rel="stylesheet" type="text/css" href="css/regStyle.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
    </head>
    <body>
        <script type="text/javascript">
        //client side form validation
        $(document).ready(function(){  
            $("#registrationForm").validate();
        });
        </script>
        <?php
            $companyNameError = $emailError =$formationDateError=$firstNameError =$lastNameError = $addressError = $cityError = $stateError = $zipcodeError ="";
            $companyName= $email=$formationDate=$firstName = $lastName  = $address = $city=$state=$zipcode="";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //check if company name is empty
                if (empty($_POST["companyName"])) {
                    $companyNameError = "Company Name is required";
                }
                else {   
                    $companyName = testData($_POST["companyName"]);
                    $companyNameError= "";
                }
                //check if email is empty
                if (empty($_POST["email"])) {
                    $emailError = "Email is required";
                } 
                else {
                    $email = testData($_POST["email"]);
                    // validation for email id
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailError = "Invalid email format";
                    }
                    else
                    {
                        $emailError = "";
                    }
                }
                //check if formation date is empty
                if (empty($_POST["formationDate"])) {
                    $formationDateError = "Formation Date is required";
                }
                else {
                    $formationDate= $_POST["formationDate"];
                    $formationDateError= "";
                }
                //check if first name is empty
                if (empty($_POST["firstName"])) {
                    $firstNameError = "First Name is required";
                } 
                else {
                    $firstName = testData($_POST["firstName"]);
                    // validation for first name entered
                    if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
                        $firstNameError = "Only letters and white space allowed";
                        
                     echo '<span class="error"></span>';

                    }
                    else {
                        $firstNameError= "";
                    }
                }
                //check if last name is empty
                if (empty($_POST["lastName"])) {
                    $lastNameError = "Last Name is required";
                } 
                else {
                    $lastName = testData($_POST["lastName"]);
                    // validation for last name entered 
                    if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
                        $lastNameError = "Only letters and white space allowed";
                    }
                    else {
                        $lastNameError = "";
                    }
                }
                //check if address is empty
                if (empty($_POST["address"])) {
                    $addressError = "address is required";
                } 
                else {
                    $address = testData($_POST["address"]);
                    if(strlen($address)>255) {
                        $addressError="Address should be less than 255 characters";
                    }
                    else {
                        $addressError = "";
                    }
                }
                //check if city is empty
                if (empty($_POST["city"])) {
                    $cityError = "city is required";
                } 
                else {
                    $city = testData($_POST["city"]);
                    $cityError = "";
                }
                //check if state is empty
                if (empty($_POST["state"])) {
                    $stateError = "state is required";
                } 
                else {
                    $state = testData($_POST["state"]);
                    $stateError = "";
                }
                //check if zip code is empty
                if (empty($_POST["zipcode"])) {
                    $zipcodeError = "zip code is required";
                } 
                else {
                    $zipcode = testData($_POST["zipcode"]);
                    if (!preg_match("/^([1-9])([0-9]){5}$/", $zipcode)) { 
                        $zipcodeError = "Your zip code must be a 6 digit number";
                    }
                    else {
                        $zipcodeError = "";
                    }
                }
                $servername="localhost";
                $username="root";
                $password="kollekatt";
                $dbname="companyDB";
                //create connection
                $conn=  new mysqli($servername,$username,$password,$dbname);
                //check connection
                if($conn->connect_error) {
                    die("Connection Failed:".$conn->connect_error);
                }
                //if there is no error insert into table
                if($companyNameError =="" && $formationDateError =="" && $emailError =="" && $firstNameError =="" && $lastNameError == "" && $addressError=="" && $cityError=="" && $stateError=="" && $zipcodeError=="") {
                    $sql="INSERT INTO company(name,formation_on,email,firstName,lastName,address,city,state,zip) VALUES('$companyName','$formationDate','$email','$firstName','$lastName','$address','$city','$state','$zipcode')";
                    $result=$conn->query($sql);
                    if($result==TRUE) {
                        
                        header('Location: index.php');
                    }
                    else {
                        echo "Insertion failed".$conn->error;
                    }
                }
            }
            function testData($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <center><h1><b>COMPANY REGISTRATION</b></h1></center><br>
        <div id="left">
        <a href="index.php">Home</a>
        </div>
        <form method="post"  id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate="novalidate">
            <div id="content">
                <table>
                    <tr>
                        <td>Company Name:</td>
                        <td><input type="text" name="companyName" value="<?php echo $companyName;?>" class="required"/>
                            <span class="error">*<?php echo $companyNameError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="text" name="email" value="<?php echo $email;?>" class="required email">
                            <span class="error">*<?php echo $emailError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Formation Date:</td>
                        <td><input type="date" name="formationDate" value="<?php echo $formationDate; ?>" class="required"/>
                            <span class="error">*<?php echo $formationDateError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>First Name:</td>
                        <td><input type="text" name="firstName" value="<?php echo $firstName;?>" class="required"/>
                            <span class="error">*<?php echo $firstNameError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Last Name:</td>
                        <td><input type="text" name="lastName" value="<?php echo $lastName;?>" class="required"/>
                            <span class="error">*<?php echo $lastNameError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><textarea name="address" rows="6" cols="50" class="required"><?php echo $address;?></textarea>
                            <span class="error">*<?php echo $addressError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td><input type="text" name="city" value="<?php echo $city;?>" class="required"/>
                            <span class="error">*<?php echo $cityError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td><input type="text" name="state" value="<?php echo $state;?>" class="required"/>
                            <span class="error">*<?php echo $stateError;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Zip Code</td>
                        <td><input type="text" name="zipcode" value="<?php echo $zipcode;?>" class="required"/>
                            <span class="error">*<?php echo $zipcodeError;?></span>
                        </td>
                    </tr><br>
                    <tr></tr>
                    <tr></tr>
                    <tr>
                        <td></td>
                        <td><input  type="submit" name="submit" value="Submit" id="submit" /></td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                </table>
            </div>
        </form>
    </body>
</html>

