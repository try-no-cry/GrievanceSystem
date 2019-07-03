@extends('admin.adminnav', ['id' => '1'])

@section('grievances')
@dump("showreportpending.blade.php")
<div style="margin-left:20px;margin-right:20px;padding-top:10px">
{{$status=""}}
<br>
<div class="panel panel-default">
    <div class="panel-heading" style="background-color:#0230C1;color:white ">
      <h2>Grievance Subject: {{$grv->subject}}</h2>   
    </div>
  </div>
<hr>
<h2>Grievance Details</h2><br>
<div class="panel panel-default">
    <div class="panel-body">
    Category    : {{$grv->category}}<br>
    Filed by    : {{$grv->user_email}}<br>
    Received On : {{Carbon\Carbon::parse($grv->created_at)->toDayDateTimeString()}} <br>
    <hr><b>Grievance Description : </b>{{$grv->description}}<br>
    </div>
    {{-- <strong style="margin-left:20px">{{Carbon\Carbon::parse($grv->created_a)->diffForHumans()}}</strong> --}}
  </div><br>
<hr>  
<h2>Reports:<button id="togglehistory" class="btn btn-outline-primary" style="float:right;font-size:15px"  >View All Reports</button></h2>
<br>


@if(count($reports_l)>0)
    
        @foreach($reports_l as $report)
        
        
            <div class="panel panel-default">
                <div class="panel-body"> Date : {{Carbon\Carbon::parse($report->created_at)->toDayDateTimeString()}}</small></div> 
              <div class="panel-body"> <i>Description : </i><br>{{$report->description}} 
                

{{-- FORM FOR ADMIN --}}

                  {{-- {!! Form::open(['action'=>'GrievanceController@adminRejectMail','method'=>'POST']) !!}

                  {{ Form::hidden('gid', $grv->id ) }}
                   --}}
                   
              <form method="POST" action="write/{{$grv->id}}">
                {{-- <form method="POST" action="GrievanceController@adminRejectMail"> --}}
                    @csrf
                    {{-- {{ Form::hidden('gid', $grv->id ) }} --}}
                    <label for="description"><br>Report Description</label>
                   <br>
                    <textarea cols="50" rows="10" class="border border-warning" placeholder="Write Your Report Here" required name="description" style="width:100%;" ></textarea>
                 <br>
                    <button type="submit" id="grad1" class="btn-grad1" name="submitReject" value="" style="border-radius:5px;border:none;margin-top:10px;">Reject And Send Report to concerned cat</button>
                    <button id="grad1" class="btn-grad" type="submit" name="submitApprove" value="" style="border-radius:5px;border:none;float:right;margin-top:10px; "  > Approve </button>

                    
                  @include('errors')
                  </form>

{{-- 
                  <form method="POST" action="/onapprove/{{$grv->id}}">
                 
                             @csrf
                           <div class="form-group">
                     
                   </form> --}}
                  
               
                          {{-- {{Form::label('desc','Report Description')}}
                          <br><br>
                          {{Form::textarea('desc','',['class'=>'form-control border border-warning','placeholder'=>'Write Your Report Here'])}}
               --}}
                  </div>

              
                  {{-- {{ Form::submit(' Reject And Send Report to concerned cat ',['class'=>'btn btn-info' ,'name'=>'toAdmin'])}} --}}
                  
                  
                  {{-- <a class="btn btn-warning" style="float:right; margin-right: 25px;" href="/gms1/public/c/onreject/{{$grv->id}}">Revert back to student for correction</a> --}}
                     
                
                  
                  {{-- {!! Form::close() !!} --}}

{{-- END FORM --}}

                {{-- <a class="btn btn-warning" style="float:right; margin-right: 25px;" href="/gms1/public/a/onreject/{{$grv->id}}">Reject</a></div>  --}}
              
              
            </div>
          
        @endforeach
        <br>
        
 
        
    
@else
    
      <p>No Latest Report Found</p>
      <br>
      {{-- <a class="btn btn-info" href="/a/asked/{{$grv->id}}" style="margin-right:30px">Ask for Report</a> --}}

     
@endif



        <div id="history" style="display:none">
                <hr><br>
            @foreach($reports as $report)
            <?php 
if($report->status==0)
$status="Pending";
if($report->status==2)
$status="Rejected";
if($report->status==1)
$status="Approved";

?>

            <div class="panel panel-default">
                    <div class="panel-body"> Date : {{$report->created_at}}  </small></div> 
                    <div class="panel-body"> Description : {{$report->description}} <h4 style="float:right;font-family:'Cambria';">Status : {{$status}} </h4></div> 
            </div>
            @endforeach
                            
        </div>
        

<script>
    $(document).ready(function(){
        $("#togglehistory").click(function(){
            $("#history").toggle();

            
        });
    });
</script>

@endsection

