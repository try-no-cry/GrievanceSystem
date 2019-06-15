@extends('cm.cellnav', ['id' => '1'])

@section('content')
@dump("cm.write.blade.php")

<div class="container">
<h2>{{$grv->subject}}</h2><hr>
    
<strong>Grievance  Description : </strong><br><br>
    <div class="panel panel-default">

    
    <div class="panel-body"> {{ $grv->description }} </div>

   
    </div>
    {!! Form::open(['action'=>'GrievanceController@storerep','method'=>'POST']) !!}

    {{ Form::hidden('gid', $grv->id ) }}
    
    

    <div class="form-group">

    
 
            {{Form::label('desc','Report Description')}}
            <br><br>
            {{Form::textarea('desc','',[ 'class'=>'form-control border border-warning col','placeholder'=>'Write Your Report Here','required'=>''])}}

      {{-- <div style="border:2px ">
        <textarea name="desc"   
        class="form-control border border-warning col"
         placeholder="Write Your Report Here" required></textarea>
      </div> --}}

    </div>


    {{ Form::submit('Submit Report',['class'=>'btn btn-info' ,'name'=>'toAdmin'])}}
    
    {{ Form::submit('Revert Report to Student',['class'=>'btn btn-danger' ,'name'=>'toUser'])}}

    {{-- <a class="btn btn-warning" style="float:right; margin-right: 25px;" href="/gms1/public/c/onreject/{{$grv->id}}">Revert back to student for correction</a> --}}
       
  
    @include('errors')
    {!! Form::close() !!}
  </div>
 

  

@endsection