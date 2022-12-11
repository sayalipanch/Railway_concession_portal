<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/style.css">
     
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Regisration Form</title>
</head>
<body>
    <div class="container">
        <header>Registration</header>

        <form action="home.html" method="post">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" id="username" placeholder="Enter your name *" required>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" name="birth_date" id="bdate" placeholder="Enter birth date *" onchange="getAge()">
                        </div>

                        <div class="input-field">
                            <label>Age</label>
                            <input type="number" name="age" id="age" value="" placeholder="Age"/>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="Enter mobile number *" onchange="checkMobileNumber(phone.value)" required>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select required>
                                <option disabled selected>Select gender *</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="text" name="email" id="email" placeholder="Enter your email *" required>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Identity Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>ID Number</label>
                            <input type="number" placeholder="Enter ID number" required>
                        </div>

                        <div class="input-field">
                            <label>Start Date</label>
                            <input type="date" placeholder="Enter your start date" required>
                        </div>

                        <div class="input-field">
                            <label>Expiry Date</label>
                            <input type="date" placeholder="Enter expiry date" required>
                        </div>

                        <div>
                            <label for="myfile">Upload Profile Photo </label><br>
                            <input type="file" id="myfile" name="myfile" required><br>
                        </div>
                    </div>

                    <button class="nextBtn" id="next" >
                        <span class="btnText">Next</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                                      
                </div> 
            </div>

            <div class="form second">
                <div class="details address">
                    <span class="title">Address Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Address Type</label>
                            <input type="text" placeholder="Permanent or Temporary" required>
                        </div>

                        <div class="input-field">
                            <label>Nationality</label>
                            <input type="text" placeholder="Enter nationality" required>
                        </div>

                        <div class="input-field">
                            <label>State</label>
                            <select class="required" required >
                                <option value="none" selected disabled hidden>Select State *</option>
                                <option>	Andhra Pradesh	</option>
                                <option>	Arunachal Pradesh	</option>
                                <option>	Assam	</option>
                                <option>	Bihar	</option>
                                <option>	Chhattisgarh	</option>
                                <option>	Goa	</option>
                                <option>	Gujarat	</option>
                                <option>	Haryana	</option>
                                <option>	Himachal Pradesh	</option>
                                <option>	Jharkhand	</option>
                                <option>	Karnataka	</option>
                                <option>	Kerala	</option>
                                <option>	Madhya Pradesh	</option>
                                <option>	Maharashtra	</option>
                                <option>	Manipur	</option>
                                <option>	Meghalaya	</option>
                                <option>	Mizoram	</option>
                                <option>	Nagaland	</option>
                                <option>	Odisha	</option>
                                <option>	Punjab	</option>
                                <option>	Rajasthan	</option>
                                <option>	Sikkim	</option>
                                <option>	Tamil Nadu	</option>
                                <option>	Telangana	</option>
                                <option>	Tripura	</option>
                                <option>	Uttar Pradesh	</option>
                                <option>	Uttarakhand	</option>
                                <option>	West Bengal	</option>
                             </select>             
                        </div>

                        <div class="input-field">
                            <label>District</label>
                            <input type="text" placeholder="Enter your district" required>
                        </div>

                        <div class="input-field">
                            <label>City</label>
                            <input type="text" placeholder="Enter city" required>
                        </div>

                        <div class="input-field">
                            <label>Pin Code</label>
                            <input type="number" placeholder="Enter Pin Code" required>
                        </div>
                    </div>
                </div>

                <div class="details family">
                    <span class="title">Family Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Father Name</label>
                            <input type="text" placeholder="Enter father name" required>
                        </div>

                        <div class="input-field">
                            <label>Mother Name</label>
                            <input type="text" placeholder="Enter mother name" required>
                        </div>

                        <div class="input-field">
                            <label>Native Place</label>
                            <input type="text" placeholder="Enter Native Place" required>
                        </div>

                        <div >
                            <input type="checkbox" id="check" onclick="show('slide')">
                            <label for="check">Choose through slider </label><br>
                        </div>

                        <div class="slidecontainer" id="slide" style="display:none;">
                            <label>Subscription Period</label>
                            <input type="range"  min="0" max="60" value="0" class="slider" id="myRange">
                            <p>Number of Months: <span id="demo"></span></p>
                        </div>
                    </div>

                    <div class="buttons">
                        <div class="backBtn">
                            <i class="uil uil-navigator"></i>
                            <span class="btnText">Back</span>
                        </div>
                        
                        <button class="sumbit" onclick="clickAlert()">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                    </div>
                </div> 
            </div>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>



</html>