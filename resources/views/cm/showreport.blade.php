@extends('cm.cellnav', ['id' => '1'])

@section('content')
@dump("cm.showreport.blade.php")
<br>
{{$status=""}}
<div class="panel panel-default">
    <div class="panel-heading" style="background-color:white;color:black; ">
      <h2>Grievance : {{$grv->subject}}</h2>
      Received on : {{Carbon\Carbon::parse($grv->created_at)->toFormattedDateString()}}
      <hr>
      <div class="container" style="margin-top:0;border-left:10px solid #0d47a1 ;width:100%;">
        <h3>Description</h3>{{$grv->description}}
      </div>
    </div>
  </div>
<hr>
<h2>Reports:
<a href="write/{{$grv->id}}" style="float:right;" class="btn btn-success">Write a Report</a>  
</h2>
<br>


@if(count($reports)>0)
    
        @foreach($reports as $report)
        
        
            <div class="panel panel-default" style="border:2px solid #0d47a1;">
                <div class="panel-body"> Date : {{Carbon\Carbon::parse($report->created_at)->toFormattedDateString()}}  </small></div> 
                <?php 
                if($report->status==0)
                $status="Pending";
                if($report->status==2)
                $status="Rejected";
                if($report->status==1)
                $status="Approved";
                
                ?>
              <div class="panel-body" style="border-top:2px solid #1976d2; background:#e3f2fd"> Description :<p> {{$report->description}}</p>  <h4 style="float:right;font-family:'Cambria';">Status : {{$status}} </h4></div> 
              
            </div>
          
        @endforeach

        {{-- {{$grvs->links()}} --}}
        
    
@else
    
      <p>No Grievances Found</p> 
     
@endif



@endsection
