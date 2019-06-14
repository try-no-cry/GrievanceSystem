@extends('cm.cellnav', ['id' => '1'])

@section('content')
@dump("cm.showreport.blade.php")
<br>
{{$status=""}}
<div class="panel panel-default">
    <div class="panel-heading" style="background-color:#0230C1;color:white ">
      <h2>Grievance : {{$grv->subject}}</h2>
      Received on : {{Carbon\Carbon::parse($grv->created_at)->toFormattedDateString()}}
      <hr>
      <div class="container" style="margin-top:0;">
        <h3>Description</h3>{{$grv->description}}
      </div>
    </div>
  </div>
<hr>
<h2>Reports:
<a href="write/{{$grv->id}}" style="float:right;" class="btn btn-default">Write a Report</a>  
</h2>
<br>


@if(count($reports)>0)
    
        @foreach($reports as $report)
        
        
            <div class="panel panel-default">
                <div class="panel-body"> Date : {{Carbon\Carbon::parse($report->created_at)->toFormattedDateString()}}  </small></div> 
                <?php 
                if($report->status==0)
                $status="Pending";
                if($report->status==2)
                $status="Rejected";
                if($report->status==1)
                $status="Approved";
                
                ?>
              <div class="panel-body"> Description : {{$report->description}}  <h4 style="float:right;font-family:'Cambria';">Status : {{$status}} </h4></div> 
              
            </div>
          
        @endforeach

        {{-- {{$grvs->links()}} --}}
        
    
@else
    
      <p>No Grievances Found</p> 
     
@endif



@endsection
