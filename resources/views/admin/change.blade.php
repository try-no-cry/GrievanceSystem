@extends('admin.adminnav',['id'=>'4'])



     @section('grievances')
     @dump("change.blade.php")
     <div style="margin-left:20px;margin-right:20px;padding-top:10px">
        <br>

        {!! Form::open(['action' => 'GrievanceController@changePassword','method'=>'POST']) !!}
       
        <div class="form-group">
                {{Form::label('password','Password')}}
                {{Form::password('Password',array('id'=>'password','class'=>'form-control border','placeholder'=>'Password'))}}
            </div>
        
        <div class="form-group">
                    {{Form::label('password','Confirm Password')}}
                    {{Form::password('CPassword',array('id'=>'password','class'=>'form-control border ','placeholder'=>'Confirm Password'))}}
                </div>
            
        <br>
    

        {{ Form::submit('Submit',['class'=>'btn btn-warning','style'=>'height:30px;width:80px;font-size:15px;' ])}}

           
                
        
        {!! Form::close() !!}
 
        
     
     @endsection
 