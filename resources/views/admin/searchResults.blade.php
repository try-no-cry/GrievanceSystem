@extends('admin.adminnav', ['id' => '1'])

@section('grievances')
@dump("showResults.blade.php")
@dump("pending.blade.php")

@if($grvs->count())
<div class="container">
    
        {{-- @if(isset($details)) --}}
            <p> The Search results for your query <b> {{ $query }} </b> are :</p>
      
<div style="margin-left:20px;margin-right:20px;padding-top:10px; width:80%;">
       
        
        
        
        </h2><hr>
        
                
                
                @foreach($grvs as $grv)
                
                
                    <div class="panel panel-default">
                        
                      <div class="panel-heading" style="background-color:#0230C1; "><h3 style="color:white;">{{$grv->subject}}</h3></div>
                      <div class="panel-body"><small>Received on : {{ Carbon\Carbon::parse($grv->created_at)->toDayDateTimeString()}} 
                       
                        </small>
                        <br>
                        
                      <?php
                      if($grv->status==2)
                      
                      echo "<a  class=\"btn btn-default\" href=\"/gms1/public/a/showreports/$grv->id\" style=\"float:right;\">View Reports</a>";
                      else
                      echo "<p  style=\"float:right;margin-right:7px\"><small>No Follow-up</small></p>"; 
                      
                      ?>
                      <a class="btn btn-default" style="float:right; margin-right: 25px;" href="/gms1/public/a/showgrievance/{{$grv->id}}">View Grievance</a>
                      
                    
                      </div>
                    </div>
                
                @endforeach
               
           
                
            
       
        
        
        </div>
        





@else 

 <h3>No such Grievance found!</h3>

@endif



@endsection