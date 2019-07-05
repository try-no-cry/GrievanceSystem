@extends('admin.adminnav', ['id' => '2'])

@section('grievances')
@dump("approved.blade.php")
<div style="margin-left:20px;margin-right:20px;padding-top:10px">
<h2>Approved Grievances : {{$category}}
</h2><hr>

@if(count($grvs)>0)
    
        @foreach($grvs as $grv)  
        
        
            <div class="panel panel-default">
   
              <div class="panel-heading" style="background-color:#0230C1; "><h3 style="color:white;">{{$grv->subject}}</h3></div>
            
              <div class="panel-body"> <small>Received on : {{ Carbon\Carbon::parse($grv->created_at)->toDayDateTimeString()}} 
               
               </small>
               <br>
               
               <a class="btn-grad" style="float:right;padding:3.5px 10px;text-decoration:none;" href="/gms1/public/a/showreportfinal/{{$grv->id}}">View Final Report</a>
              
              </div> 
               
            </div>
        
        @endforeach

        {{$grvs->links()}}
        
    
@else
    
      <p>No Grievances Found</p> 
     
@endif

          </div>

@endsection