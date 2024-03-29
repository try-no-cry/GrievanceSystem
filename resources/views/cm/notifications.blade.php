@extends('cm.cellnav', ['id' => '2'])

@section('content')
@dump("cm.notifications.blade.php")


<div style="margin-left:20px;margin-right:20px;padding-top:10px">
<h2>Notifications</h2><hr>



        @if(count($data['notis'])>0)
    
        @foreach($data['notis'] as $noti)
        
        
                <div class="panel panel-default">
                        <div class="panel-heading" style="background-color:#0230C1;color:white ">
                                A message from :&nbsp;{{$noti->send_email}}<br>
                                Message: &nbsp;{{$noti->msg}} 
                               
                        </div>
                        <div class="panel-body">
                               
                               <b> Concerned Grievance :</b><br>&nbsp;{{$noti->subject}}
                                <form action="/gms1/public/visibility" method="post">
                                        {!! csrf_field() !!}
                                        <input  name="id" value="{{$noti->id}}" hidden>
                                        <input style="float:right;margin-left:10px;" class="btn btn-primary" value="Mark as Viewed" type="submit">
                                </form>
                        

                        <form action="/gms1/public/c/showreport/write/{{ $noti->grievance_id }}" method="GET" >

                                        <input style="float:right;" class="btn btn-primary" value="Write A Report" type="submit">

                        </form>
                        
                        </div>        
                </div>
        
       
        @endforeach

@else
    
        <p>No New Notifications Found</p> 
  
@endif
<hr>

<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#viewed">Viewed Notifications</button>

<hr>
</div>


<div id="viewed" class="collapse" style="margin-left:20px;margin-right:20px;padding-top:10px;width:100%">

        
        @if(count($data['vnotis'])>0)
    
        @foreach($data['vnotis'] as $vnoti)
        
        <div class="container" style="margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;width:90%;">
                <div class="panel panel-default" >
                        <div class="panel-heading" style="background-color:#0230C1;color:white ">
                                        A message from :&nbsp;{{$vnoti->send_email}}<br>
                                        Message: &nbsp;{{$noti->msg}} 
                               
                                </div>
                                <div class="panel-body">
                                       
                                       <b> Concerned Grievance :</b><br>&nbsp;{{$noti->subject}}
                                {{-- <form action="/visibility" method="post">
                                        {!! csrf_field() !!}
                                        <input  name="id" value="{{$noti->id}}" hidden>
                                        <input style="float:right" class="btn btn-default" value="Mark as Viewed" type="submit">
                                </form> --}}
                        </div>        
                </div>
        </div>
       
        @endforeach

@else
    
        <p>No Viewed-Notifications Found</p> 
  
@endif
</div>
@endsection

