@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="user-wrapper">
                    <ul class="users">
                        @foreach($users as $user)
                            <li class="user" id="{{ $user->id }}">
                                {{--will show unread count notification--}}
                                @if($user->unread)
                                    <span class="pending">{{ $user->unread }}</span>
                                @endif

                                <div class="media">
                                    <div class="media-left">
                                        <img src="{{ $user->avatar }}" alt="" class="media-object">
                                    </div>

                                    <div class="media-body">
                                        <p class="name">{{ $user->name }}</p>
                                        <p class="email">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-8" id="messages">

            </div>
        </div>
    </div>


    <script>


    
        var auto_refresh = setInterval(
            function () {
                $('.container-fluid').load('home.blade.php').fadeIn("slow");
            }, 1); // refresh setiap 10000 milliseconds
    
    



var ajaxku = buatAjax();
var tname = 0;
var pesanakhir = 0;
var timer;
function taruhNama(){
if(tname==0){
document.getElementByClass(“name”).disabled = “true”;
tname = 1;
}else{
document.getElementByClass(“name”).disabled = “”;
tname = 0;
}
ambilPesan();
}
function buatAjax(){
if(window.XMLHttpRequest){
return new XMLHttpRequest();
}else if(window.ActiveXObject){
return new ActiveXObject(“Microsoft.XMLHTTP”);
}
}
function ambilPesan(){
namaku = document.getElementByClass(“name”).value
if(ajaxku.readyState == 4 || ajaxku.readyState == 0){
ajaxku.open(“GET”,”ambilchat.php?akhir=”+pesanakhir+”&name=”+namaku+”&sid
=”+Math.random(),true);
ajaxku.onreadystatechange = aturAmbilPesan;
ajaxku.send(null);
}
}
function aturAmbilPesan(){
if(ajaxku.readyState == 4){
var chat_div = document.getElementById(“div_chat”);
var data = eval(“(“+ajaxku.responseText+”)”);
for(i=0;i<data.messages.pesan.length;i++){
chat_div.innerHTML += “<font
color=red>”+data.messages.pesan[i].name+”</font> “;
chat_div.innerHTML += “<font
size=1>(“+data.messages.pesan[i].waktu+”)</font> “;
chat_div.innerHTML += ” :
“+data.messages.pesan[i].teks+”<br>”;
chat_div.scrollTop = chat_div.scrollHeight;
pesanakhir = data.messages.pesan[i].id;
}
}
timer = setTimeout(“ambilPesan()”,1000);
}
function kirimPesan(){
pesannya = document.getElementById(“pesan”).value
namaku = document.getElementByClass(“name”).value
if(pesannya != “” && document.getElementById(“name”).value !=””){
ajaxku.open(“GET”,”ambilchat.php?akhir=”+pesanakhir+”&nama=”+namaku+”&pes
an=”+pesannya+”&sid=”+Math.random(),true);
ajaxku.onreadystatechange = aturAmbilPesan;
ajaxku.send(null);
document.getElementById(“pesan”).value = “”;
}else{
alert(“Nama atau pesan masih kosong”);
}
}
function aturKirimPesan(){
clearInterval(timer);
ambilPesan();
}
function blockSubmit() {
kirimPesan();
return false;
}
</script>


@endsection
