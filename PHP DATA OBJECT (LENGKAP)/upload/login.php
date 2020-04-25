<?php
include('../config/database_connection.php');
include_once 'header.php';
 
 
$message = '';
 
if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}
 
if(isset($_POST["login"]))
{
 $query = "
   SELECT * FROM login 
    WHERE username = :username
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
    array(
      ':username' => $_POST["username"]

     )
  );
  $count = $statement->rowCount();
  if($count > 0)
 {
  $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if(password_verify($_POST["password"], $row["password"]))
      {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['namalengkap'] = $row['namalengkap'];
        $sub_query = "
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$row['user_id']."')
        ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();
        header("location:index.php");
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
       <input type="text" name="username" class="form-control form-control-lg form-rounded" required />
      </div>
      <div class="form-group">
       <label>Kata sandi</label>
       <input type="password" name="password" class="form-control form-control-lg form-rounded" required />
      </div>
      <div class="form-group">
       <input type="submit" name="login" class="btn btn-primary btn-lg btn-block btn-rounded" value="Masuk" />
      </div>
     </form>