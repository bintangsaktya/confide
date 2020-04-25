<?php
include('../config/database_connection.php');
 include_once 'header.php';
 
$message = '';
 
if(isset($_SESSION['admin_id']))
{
 header('location:index.php');
}
 
if(isset($_POST["admin_register"]))
{
  $namalengkapadmin = trim($_POST["namalengkapadmin"]);
 $usernameadmin = trim($_POST["usernameadmin"]);
 $passwordadmin = trim($_POST["passwordadmin"]);
 $check_query = "
 SELECT * FROM admin_login 
 WHERE usernameadmin = :usernameadmin
 ";
 $statement = $connect->prepare($check_query);
 $check_data = array(
  ':usernameadmin'  => $usernameadmin
 );
 if($statement->execute($check_data)) 
 {
  if($statement->rowCount() > 0)
  {
   $message .= '<p><label>Nama sudah terdaftar !</label></p>';
  }
  else
  {
   if(empty($usernameadmin))
   {
    $message .= '<p><label>Harap isi Nama !</label></p>';
   }
   if(empty($passwordadmin))
   {
    $message .= '<p><label>Harap isi kata sandi !</label></p>';
   }
   else
   {
    if($passwordadmin != $_POST['confirm_password'])
    {
     $message .= '<p><label>Kata sandi tidak sama !</label></p>';
    }
   }
   if($message == '')
   {
    $data = array(
     ':usernameadmin'  => $usernameadmin,
     ':namalengkapadmin'  => $namalengkapadmin,
     ':passwordadmin'  => password_hash($passwordadmin, PASSWORD_DEFAULT)
    );
 
    $query = "
    INSERT INTO admin_login 
    (namalengkapadmin, usernameadmin, passwordadmin) 
    VALUES (:namalengkapadmin, :usernameadmin, :passwordadmin)
    ";
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
     $message = "<label>Pendaftaran berhasil !</label>";
    }
   }
  }
 }
}
 
?>
 
 <center>  <img src="../img/logomax.png" width="100px"></center>
   <br />
   <div class="panel panel-default">
      <div class="panel-heading"><h4>Daftar Untuk Admin Baru</h4></div>
    <div class="panel-body">
     <form method="post">
      <span class="text-danger"><?php echo $message; ?></span>
      <div class="form-group">
       <label>Masukkan Nama Lengkap</label>
       <input type="text" name="namalengkapadmin" class="form-control form-control-lg" />
      </div>

      <label>Masukkan Username</label>
       <input type="text" name="usernameadmin" class="form-control form-control-lg" />
      </div>

      <div class="form-group">
       <label>Kata sandi</label>
       <input type="password" name="passwordadmin" class="form-control form-control-lg" />
      </div>
      <div class="form-group">
       <label>Ulangi Kata sandi</label>
       <input type="password" name="confirm_password" class="form-control form-control-lg" />
      </div>
      <div class="form-group">
       <input type="submit" name="admin_register" class="btn btn-danger btn-lg" value="Daftar" />
      </div>
      <div align="center">
       <a href="admin_login.php"><u>Admin Login</u></a>
      </div>
     </form>
    </div>
   </div>