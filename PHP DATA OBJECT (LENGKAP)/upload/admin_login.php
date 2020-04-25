<?php
include('../config/database_connection.php');
include_once 'header.php';
 
 
$message = '';
 
if(isset($_SESSION['admin_id']))
{
 header('location:admin_side.php');
}
 
if(isset($_POST["admin_login"]))
{
 $query = "
   SELECT * FROM admin_login 
    WHERE usernameadmin = :usernameadmin
 ";
  $statement = $connect->prepare($query);
  $statement->execute(
      array(
        ':usernameadmin' => $_POST["usernameadmin"]

      )
    );
    $count = $statement->rowCount();
    if($count > 0)
  {
    $result = $statement->fetchAll();
      foreach($result as $row)
      {
        if(password_verify($_POST["passwordadmin"], $row["passwordadmin"]))
        {
        
          $statement = $connect->prepare($sub_query);
          $statement->execute();
          $_SESSION['admin_login_details_id'] = $connect->lastInsertId();
          header("location:admin_side.php");
        }
        else
        {
        $message = "<label>Kata sandi kamu salah !</label>";
        }
      }
  }
  else
  {
    $message = "<label>Username kamu salah !</labe>";
  }
  }
  
?>
 
   <center>  <img src="../img/logomax.png" width="100px"></center>
 
     <form method="post">
      <p class="text-danger"><?php echo $message; ?></p>
      <div class="form-group">
       <label>Username</label>
       <input type="text" name="usernameadmin" class="form-control form-control-lg form-rounded" required />
      </div>
      <div class="form-group">
       <label>Kata sandi</label>
       <input type="password" name="passwordadmin" class="form-control form-control-lg form-rounded" required />
      </div>
      <div class="form-group">
       <input type="submit" name="admin_login" class="btn btn-primary btn-lg btn-block btn-rounded" value="Masuk" />
      </div>
     </form>