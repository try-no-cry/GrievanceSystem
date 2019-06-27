<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
  {{-- jquery for categories for particular cell member  --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

  {{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>   --}}
  <script src="/js/table2excel.js" type="text/javascript"></script>  
<style>
    body{
        padding:0px;
        margin:0px;
    }
    </style>
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
  font-size: 21px;
  color: #000000;
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

@media screen and (max-width: 700px) {
  .sidenav{
    width: 100%;
    height: auto;
    position: relative;
    display: block;
  }
  
  .sidebar a {float: left;} */
   div.content {margin-left: 0;}
}

/* @media screen and (max-width: 450px) {
  .dropdown .sidenav a {
    text-align: center;
    float: none;
  }
} */


.dropdown {
  /* position: relative; */
  display: inline-block;
  width: 160px;

}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #0230C1}

.dropdown:hover .dropdown-content {
  display: block;
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
else if({{$id}}=='4')
$(document).ready(function(){
$("#4").css("color","#FFFFFF");  
$("#4").css("background-color","#0230C1");
});


</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>

<div class="sidenav">
    
    {{-- <div class="dropdown">
        <a id="0" href="/a" >New</a>
        <div class="dropdown-content">
          <a href="/a/" >All</a>
          <a href="/a/new/1" >Academics</a>
          <a href="/a/new/2" >Cleanliness</a>
          <a href="/a/new/3" >Infrastructure</a>
          <a href="/a/new/4">Harassment</a>
          <a href="/a/new/5">Disciplinary Action</a>
        </div>
      </div> --}}

      
        <div class="dropdown">
            <a id="1" href="/gms1/public/a/pending" style="font-size:22px;"  >Pending <small class="fa fa-caret-down" style="margin-left:10px;"></small></a><hr class="divider">
            <div class="dropdown-content">
              <a href="/gms1/public/a/pending" style="font-size:22px;">All</a><hr class="divider">
              <a href="/gms1/public/a/pending/1" style="font-size:22px;">Academics</a><hr class="divider">
              <a href="/gms1/public/a/pending/2"style="font-size:22px;" >Cleanliness</a><hr class="divider">
              <a href="/gms1/public/a/pending/3" style="font-size:22px;">Infrastructure</a><hr class="divider">
              <a href="/gms1/public/a/pending/4"style="font-size:22px;">Harassment</a><hr class="divider">
              <a href="/gms1/public/a/pending/5" style="font-size:22px;">Disciplinary Action</a><hr class="divider">
            </div>
          </div>
        
          <div class="dropdown">
            <a id="2" href="/gms1/public/a/approved" style="font-size:22px;" >Approved <small class="fa fa-caret-down" style="margin-left:10px;"></small></a><hr class="divider">
            <div class="dropdown-content">
              <a href="/gms1/public/a/approved" style="font-size:22px;" >All</a><hr class="divider">
              <a href="/gms1/public/a/approved/1" style="font-size:22px;">Academics</a><hr class="divider">
              <a href="/gms1/public/a/approved/2" style="font-size:22px;">Cleanliness</a><hr class="divider">
              <a href="/gms1/public/a/approved/3" style="font-size:22px;">Infrastructure</a><hr class="divider">
              <a href="/gms1/public/a/approved/4" style="font-size:22px;">Harassment</a><hr class="divider">
              <a href="/gms1/public/a/approved/5" style="font-size:22px;">Disciplinary Action</a><hr class="divider">
            </div>
          </div>
  
          <a href="/gms1/public/a/notifications" id="3" style="font-size:22px;">Notifications  
            <?php 
          
                      $notis = DB::table('notifications')->where('rec_email',auth()->user()->email)->where('status',0)->get();
                      $count=$notis->count();
                      if($count!=0)
                      echo"<small style='color:red;'>$count</small>";
            ?></a><hr class="divider">
          
          <a id="4" href="/gms1/public/a/change" >Change Password</a><hr class="divider">
          {{-- <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Change Password') }}
            </a>
         --}}
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      
          <a class="dropdown-item" style="font-size:22px;"   href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a><hr class="divider">

            <a id="4" href="/gms1/public/a/generateReport" >Generate Report</a><hr class="divider">

        
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
          {{-- <a id="5" href="/gms1/public/a/changeEcell" >Change E-cell members</a> --}}
      
    </div>
  
<div class="main">
  <div class="container" style="padding-top:10px; width:70%;">
    <form action="/gms1/public/a/search" method="POST" role="search">
      {{ csrf_field() }}
      <div class="input-group" >
          <input type="text"  style="text-align:center;height:35px;width:80%;margin-left:10%" name="q"
              placeholder="Search Grievance"> <span class="input-group-btn">
              <button type="submit" class="btn btn-default" style="height:35px;">
                  <span class="glyphicon glyphicon-search" style="font-size:10px;height:35px;padding-left:5px;padding-top:6px;padding-right:6px;"></span>
                  {{-- glyphicon glyphicon-search --}}
                </button>
          </span>
      </div>
    </form>

  </div>  
  @yield('grievances')


  <div class="container">
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

          <script>
          CKEDITOR.replace( 'article-ckeditor' );
         </script>

   </div>


</div>
  
</body>
</html> 

