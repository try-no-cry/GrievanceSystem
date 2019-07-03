@extends('admin.adminnav', ['id' => '1'])

@section('grievances')
@dump("pending.blade.php")


<div style="margin-left:20px;margin-right:20px;padding-top:10px">
<h2>Pending Grievances : {{$category}}  



</h2><hr>

        
        @if(count($grvs)>0)
        
        @foreach($grvs as $grv)
        
        
            <div class="panel panel-default">
                
              <div class="panel-heading" style="background-color:#0230C1; "><h3 style="color:white;">{{$grv->subject}}</h3></div>
              <div class="panel-body"><small>Received on : {{ Carbon\Carbon::parse($grv->created_at)->toDayDateTimeString()}} 
               
                </small>
                <br>
                <small><strong style="margin-left:90px;">{{ Carbon\Carbon::parse($grv->created_at)->diffForHumans()}}</strong></small>
                
              <?php
              if($grv->status==2)
              
              echo "<a  class=\"btn btn-primary\" href=\"/gms1/public/a/showreports/$grv->id\" style=\"font-size:16px;float:right;\">View Reports</a>";
              else
              echo "<p  style=\"float:right;margin-right:7px\"><small>No Follow-up</small></p>"; 
              
              ?>
              <a class="btn btn-primary" style="float:right; margin-right: 25px; font-size:16px;" href="/gms1/public/a/showgrievance/{{$grv->id}}">View Grievance</a>
              
            
              </div>
            </div>
        
        @endforeach
       
        {{$grvs->links()}}
        
    
@else
    
      <p>No Grievances Found</p> 
     
@endif


</div>

@endsection