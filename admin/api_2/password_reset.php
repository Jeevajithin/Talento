<?php
session_start();
require 'connection.php';

if ($con->conect_error) 
{
    die("conection failed: " . $con->conect_error);
}

if (!isset($_GET['token'])) 
{
   $_SESSION['error_message'] = "No token.";
}
else
{
	$token = $con->real_escape_string($_GET['token']);

	$sql = "SELECT * FROM password_reset WHERE token='$token'";
	$result = $con->query($sql);

	if ($result->num_rows == 0) 
	{
    	$_SESSION['error_message'] = "Invalid token.";   
	}
	else
	{
		$row = $result->fetch_assoc();
    $expires_at = date('Y-m-d H:i:s', strtotime($row['expires_at'])); // Convert to the same format
    date_default_timezone_set('Asia/Kolkata');
    $current_time = date('Y-m-d H:i:s');

      if ($current_time > $expires_at) 
      {
          $_SESSION['error_message'] = "Token has expired.";
      }

		else if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
 
    		$password = $con->real_escape_string($_POST['password']);
    		$confirm_password = $con->real_escape_string($_POST['confirm_password']);

    		if ($password != $confirm_password) 
			{
        		$_SESSION['error_message'] = "Passwords do not match.";
    	}
			else 
			{
    
       $update_sql = "UPDATE tl_profile SET password='$password' WHERE id in (SELECT user_id FROM password_reset WHERE token='$token')";
       if ($con->query($update_sql) === TRUE) 
		    {
           $_SESSION['success_message'] = "Password updated successfully.";    
        } 
       else 
		    {
           $_SESSION['error_message'] = "Error updating password: " . $con->error;
        }
    		}
		}
	}
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset</title>
  <link href="../asset/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color:#E5E1E1;
    }
    .reset-form {
      max-width: 400px;
      margin: 50px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .reset-form h2 {
      color: #007bff;
    }
    .reset-form .btn-primary {
      background-color: #ffc107;
      border-color: #ffc107;
    }
    .reset-form .btn-primary:hover {
      background-color: #ffca2b;
      border-color: #ffca2b;
    }
  </style>
</head>
<body>
  
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3 reset-form">
        <h2 class="text-center mb-4">Reset Password</h2>
		  
        <?php if (isset($_SESSION['error_message'])) 
        {
           ?>
            <div class="alert alert-danger" role="alert">

				<?php echo $_SESSION['error_message']; ?>
		  </div>
        <?php unset($_SESSION['error_message']); } ?>

        
        <?php if (isset($_SESSION['success_message'])) 
        {
           ?>
            <div class="alert alert-success" role="alert">

				<?php echo $_SESSION['success_message']; ?>
		  </div>
        <?php unset($_SESSION['success_message']); } ?>
		  
        <form method="post" action="password_reset.php?token=<?php echo $_REQUEST['token'] ?>">
          <div class="form-group">
            <label for="inputPassword">New Password</label>
            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="New Password" required>
          </div>
          <div class="form-group">
            <label for="inputConfirmPassword">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>
      </div>
    </div>
  </div>

  <script src="../asset/jquery-3.5.1.slim.min.js"></script>
  <script src="../asset/popper.min.js"></script>
  <script src="../asset/bootstrap.min.js"></script>
</body>
</html>
