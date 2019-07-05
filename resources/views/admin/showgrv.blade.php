@extends('admin.adminnav', ['id' => '1'])

@section('grievances')

@dump("showgrv.blade.php")


<div style="margin-left:20px;margin-right:20px;padding-top:10px">
    <br>
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color:#0230C1;color:white ">
          <h2>Grievance : {{$grv->subject}}</h2>   
        </div>
      </div>
    <h2>Grievance Details</h2><br>
    <div class="panel panel-default" style="border-left:10px solid blue; border-top:10px solid #ffc300;">
        <div class="panel-body">
        Category    : {{$grv->category}}<br>
        Filed by    : {{$grv->user_email}}<br>
        
        Received on : {{ Carbon\Carbon::parse($grv->created_at)->toDayDateTimeString()}} 
              
         
          <br>
          <hr class="divider" style="background-color:blue; height:1px;"><br>
        <i>Description</i> :<p> {{$grv->description}}</p><br>
        </div>
      </div><br>
    <hr>  
    



@endsection