@extends('cm.cellnav', ['id' => '1'])

@section('content')
@dump("cm.history.blade.php")
<div style="margin-left:20px;margin-right:20px;padding-top:10px">
{{$status=""}}
<h2>All Grievances:</h2>
<hr>


@if(count($grvs)>0)
    
    @foreach($grvs as $grv)
        
        
        <div class="panel panel-default">
            
            <?php 
            if($grv->status==1)
            $status="Approved";
            else 
            $status="Pending";
            ?>
                
            <div class="panel-heading" style="background-color:#0230C1; "><h3 style="color:white;">
                <a  href="show/{{$grv->id}}" style="color:white;">{{$grv->subject}}</a>
                <span style="float:right;font-size:16px">Status : {{$status}}</h3></span> </div>
                <div class="panel-body">
                  <small>Received on : {{(Carbon\Carbon::parse($grv->created_at)->toFormattedDateString())}} </small>
                  <a  class="btn btn-primary" href="/gms1/public/c/showreport/{{$grv->id}}" style="float:right;margin-left:10px">View Reports</a>
                  
                  <?php 
                  
                  if($status=="Pending")
                  echo "<a href=\"/gms1/public/write/$grv->id\" style=\"float:right;\" class=\"btn btn-primary\">Write a Report</a>  ";

                  ?>
                
                </div>
        </div>
        
    @endforeach
        
    
@else
    
      <p>No Grievances Found</p> 
     
@endif

</div>
        
@endsection