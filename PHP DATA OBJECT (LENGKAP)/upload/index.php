<?php
include('../config/database_connection.php');
 include_once 'header.php';
//session_start();
 
if(!isset($_SESSION['user_id']))
{
 header("location:login.php");
}
 
?>
 <head>
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
 </head>
   <center>  <img src="../img/logomax.png" width="100px"></center>
<a href="../" class="btn btn-light"><span class="fa fa-arrow-left"></span> Balik</a>
<div class="alert alert-notice" role="alert">
  <center>
		"Halo Sob! Selamat Datang!"</center>
</div>
 
   <div class="row">
    <div class="col-md-3 col-sm-3">
     <input type="hidden" id="is_active_group_chat_window" value="no" />
     <button type="button" name="group_chat" id="group_chat" class="btn btn-primary">Butuh Jawaban Cepat ?</button>
    </div><br>



  <div class="w3-panel w3-green w3-display-container">
  <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">×</span>
  <h3>Masa Coba Gratis!</h3>
  <p>Halo sob! saat ini Confide memberikan layanan chat gratis sementara ! </p>
</div>



    <div class="col-md-4 col-sm-4">
     <p align="right">Anda Login Sebagai :<?php echo $_SESSION['namalengkap']; ?> - <a href="logout.php">Logout</a></p>
    </div>
   </div>
   <div class="table table-responsive-sm ">
    
    <div id="user_details"></div>
    <div id="user_model_details"></div>
   </div>
  </div>
    </body>  
</html>
 
<style>
 
body{
  background-image: url(../img/banner/banner.png);
  background-size: cover;
  background-repeat: no-repeat;
  color: white;
}
.chat_message_area
{
 position: relative;
 width: 100%;
 height: auto;
 background-color: #FFF;
    border: 1px solid #ccc;
    border-radius: 3px;
}
 
#group_chat_message
{
 width: 100%;
 height: auto;
 min-height: 80px;
 overflow: auto;
 padding:6px 24px 6px 12px;
}
 
.image_upload
{
 position: absolute;
 top:3px;
 right:3px;
}
.image_upload > form > input
{
    display: none;
}
 
.image_upload img
{
    width: 24px;
    cursor: pointer;
}
 
</style>  
 
<div id="group_chat_dialog" title="ONLINE GROUP CHAT">
 <div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;">
 
 </div>
 <div class="form-group">
  <!--<textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea>!-->
  <div class="chat_message_area">
   <div id="group_chat_message" contenteditable>
 
   </div>
   <div class="image_upload">
    <form id="uploadImage" method="post" action="upload.php">
     <label for="uploadFile"><img src="img/upload.png" /></label>
     <input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png"/>
    </form>
   </div>
  </div>
 </div>
 <div class="form-group" align="right">
  <button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info btn-sm"><span class="fa fa-paper-plane"></span> Kirim</button>
 </div>
</div>

<div class="popup">
    <div id="box">
      <a class="close" href="#">X</a>
      <center>
      <img src="../img/banner/halo.png" width="600px"></center>
    </div>    
  </div>
  <!-- akhir dari popup -->
  
  

 
 <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('a.close').click(function(eve){
      
      eve.preventDefault();
      $(this).parents('div.popup').fadeOut('slow');
    });
  });
</script>
<style type="text/css">
  body{
    width:100%;
    height:100%;
    margin:0;
    padding:0;

  }
  div.popup{
    position:fixed;
    top:0;
    bottom:0;
    left:0;
    right:0;
    width:100%;
    height:100%;
    color: black;
    background-image: url(../img/banner/bannertrans.png);
    background-size: cover;
    background-repeat: no-repeat;
    
  }
  
  div#box{
    margin:5% auto;
    background:#fff;
    width:50%;
    height:50%;
    -webkit-box-shadow:0 0 15px #000;
    -moz-box-shadow:0 0 15px #000;
    box-shadow:0 0 15px #000;
  }
  
  a.close{
    text-decoration:none;
    color:#000;
    margin:10px 15px 0 0;
    float:right;
    font-family:tahoma;
    font-size:20px;
  }
</style>
</head>

<script>  
$(document).ready(function(){
 
 fetch_user();
 
 setInterval(function(){
  update_last_activity();
  fetch_user();
  update_chat_history_data();
  fetch_group_chat_history();
 }, 5000);
 
 function fetch_user()
 {
  $.ajax({
   url:"fetch_user.php",
   method:"POST",
   success:function(data){
    $('#user_details').html(data);
   }
  })
 }
 
 function update_last_activity()
 {
  $.ajax({
   url:"update_last_activity.php",
   success:function()
   {
 
   }
  })
 }
 
 function make_chat_dialog_box(to_user_id, to_user_name)
 {
  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="'+to_user_name+'">';
  modal_content += '<div style="height:400px; border:1px solid #bbb; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += fetch_user_chat_history(to_user_id);
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message" placeholder="Tulis pesan kamu"></textarea>';
  modal_content += '</div><div class="form-group" align="right">';
  modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat"><span class="fa fa-paper-plane"></span> Kirim</button></div></div>';
  $('#user_model_details').html(modal_content);
 }
 
 $(document).on('click', '.start_chat', function(){
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  make_chat_dialog_box(to_user_id, to_user_name);
  $("#user_dialog_"+to_user_id).dialog({
   autoOpen:false,
   width:400
  });
  $('#user_dialog_'+to_user_id).dialog('open');
  $('#chat_message_'+to_user_id).emojioneArea({
   pickerPosition:"top",
   toneStyle: "bullet"
  });
 });
 
 $(document).on('click', '.send_chat', function(){
  var to_user_id = $(this).attr('id');
  var chat_message = $('#chat_message_'+to_user_id).val();
  $.ajax({
   url:"insert_chat.php",
   method:"POST",
   data:{to_user_id:to_user_id, chat_message:chat_message},
   success:function(data)
   {
    //$('#chat_message_'+to_user_id).val('');
    var element = $('#chat_message_'+to_user_id).emojioneArea();
    element[0].emojioneArea.setText('');
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 });
 
 function fetch_user_chat_history(to_user_id)
 {
  $.ajax({
   url:"fetch_user_chat_history.php",
   method:"POST",
   data:{to_user_id:to_user_id},
   success:function(data){
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 }
 
 function update_chat_history_data()
 {
  $('.chat_history').each(function(){
   var to_user_id = $(this).data('touserid');
   fetch_user_chat_history(to_user_id);
  });
 }
 
 $(document).on('click', '.ui-button-icon', function(){
  $('.user_dialog').dialog('destroy').remove();
  $('#is_active_group_chat_window').val('no');
 });
 
 $(document).on('focus', '.chat_message', function(){
  var is_type = 'yes';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {
 
   }
  })
 });
 
 $(document).on('blur', '.chat_message', function(){
  var is_type = 'no';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {
    
   }
  })
 });
 
 $('#group_chat_dialog').dialog({
  autoOpen:false,
  width:400
 });
 
 $('#group_chat').click(function(){
  $('#group_chat_dialog').dialog('open');
  $('#is_active_group_chat_window').val('yes');
  fetch_group_chat_history();
 });
 
 $('#send_group_chat').click(function(){
  var chat_message = $('#group_chat_message').html();
  var action = 'insert_data';
  if(chat_message != '')
  {
   $.ajax({
    url:"group_chat.php",
    method:"POST",
    data:{chat_message:chat_message, action:action},
    success:function(data){
     $('#group_chat_message').html('');
     $('#group_chat_history').html(data);
    }
   })
  }
 });
 
 function fetch_group_chat_history()
 {
  var group_chat_dialog_active = $('#is_active_group_chat_window').val();
  var action = "fetch_data";
  if(group_chat_dialog_active == 'yes')
  {
   $.ajax({
    url:"group_chat.php",
    method:"POST",
    data:{action:action},
    success:function(data)
    {
     $('#group_chat_history').html(data);
    }
   })
  }
 }
 
 $('#uploadFile').on('change', function(){
  $('#uploadImage').ajaxSubmit({
   target: "#group_chat_message",
   resetForm: true
  });
 });
 
 $(document).on('click', '.remove_chat', function(){
  var chat_message_id = $(this).attr('id');
  if(confirm("Apakah anda yakin akan menghapus chat ini?"))
  {
   $.ajax({
    url:"remove_chat.php",
    method:"POST",
    data:{chat_message_id:chat_message_id},
    success:function(data)
    {
     update_chat_history_data();
    }
   })
  }
 });
 
 
});  
</script>
 
<?php
 
?>