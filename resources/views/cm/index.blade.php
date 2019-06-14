@extends('cm.cellnav', ['id' => '0'])

@section('content')
@dump("cm.index.blade.php")

<h2>Grievances:</h2><hr>

@if(count($grvs)>0)

        @foreach($grvs as $grv)
        
        <div style="margin-left:20px;margin-right:20px;padding-top:10px;">

            <div class="panel panel-default" style="width:90%;">
                

            <a href="/gms1/public/c/show/{{$grv->id}}">  
              <div class="panel-heading" style="background-color:#0230C1; ">
                <h3 style="color:white" >{{$grv->subject}}</h3>
              </div>
            </a>
              <div class="panel-body"> <small>Received on : {{Carbon\Carbon::parse($grv->created_at)->toFormattedDateString()}}
              <a href="/gms1/public/write/{{$grv->id}}" style="float:right" class="btn btn-default">Write a Report</a>
               
               </small>
    
              
              </div> 
               
            </div>
          </div>
        @endforeach

        {{$grvs->links()}}
        
    
@else
    
      <p>No Grievances Found</p> 
     
@endif



@endsection
