<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  {{-- jquery for categories for prticular cell members  --}}
<style>
body {
  font-family:'Cambria';
}

.sidenav {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #FFC300;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 10px 8px 6px 16px;
  text-decoration: none;
  font-size: 23px;
  color: black;
  display: block;
}

.sidenav a:hover {
  background-color: #0230C1;
  color:white;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  font-size: 18px; /* Increased text to enable scrolling */
  padding: 0px 20px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}


.divider{
      margin: 0;
  padding: 0;
    }
</style>
</head>
<script>
if({{$id}}=='0')
$(document).ready(function(){
$("#0").css("color","#FFFFFF");  
$("#0").css("background-color","#0230C1");
});
else if({{$id}}=='1')
$(document).ready(function(){
$("#1").css("color","#FFFFFF");  
$("#1").css("background-color","#0230C1");
});
else if({{$id}}=='2')
$(document).ready(function(){
$("#2").css("color","#FFFFFF");  
$("#2").css("background-color","#0230C1");
});
else if({{$id}}=='3')
$(document).ready(function(){
$("#3").css("color","#FFFFFF");  
$("#3").css("background-color","#0230C1");
});
</script>
<body>

<div class="sidenav">

  {{-- @if(auth()->user()->roles==2) --}}

   <a id="0" href="/gms1/public/u" style="font-size:22px;" >New Grievance</a><hr class="divider">
  {{-- @endif --}}
  <a id="1" href="/gms1/public/u/history" style="font-size:22px;" >History</a><hr class="divider">
  <a id="2" href="/gms1/public/u/notifications" style="font-size:22px;" >Notifications   
    <?php 

              $notis = DB::table('notifications')->where('rec_email',auth()->user()->email)->where('status',0)->get();
              $count=$notis->count();
              if($count!=0)
              echo"<small style='color:red; font-size:15px; padding-left:0px;'>$count</small>";
    ?></a><hr class="divider">
  <a id="3" href="/gms1/public/u/change" style="font-size:22px;">Change Password</a> <hr class="divider">
  <a class="dropdown-item" style="font-size:22px;" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a><hr class="divider">
        
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      
  {{-- <a href="/" onclick="signOut();">Sign out</a> --}}

</div>

<div class="main">
  @include('incuser.messages')

{{-- @if(auth()->user()->role==2) --}}
  @yield('grievances')
 {{-- @endif  --}}
  
  
 <div class="container">
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

          <script>
          CKEDITOR.replace( 'article-ckeditor' );
         </script>

   </div>
</div>
<script>

   
</body>
</html> 
