{{--@extends ('incuser.navbar')--}}
@extends ('user.usernav', ['id' => '0'])


     @section('grievances')
    
     @dump("user.new_grv.blade.php")
     <h1 style="color: #0230C1; text-align:center">Grievance Form</h1><hr style="margin-top:0;padding-top:0; border:0.5px solid black; width:80%">
        
        {!! Form::open(['action' => 'GrievanceController@store','method'=>'POST']) !!}
        <div style="border:0.5px solid rgba(86,61,124,.2); padding:20px; border-radius:20px; background-color:#eee;">
        <div class=""  >
                      {{Form::label('category','Category')}}

            <br>
      {{-- <div class=dropClass style="background-color:black;border:5px solid red;"> --}}
            {{Form::select('category',['1' => 'Academics', '2' => ' Cleanliness','3' => ' Infrastructure','4' => 'Harassment','5' => 'Disciplinary Action'],['class'=>'ajeebsa'])}}
        {{-- </div> --}}
    </div>
       
        <div class="form-group">
            {{Form::label('subject','Subject')}}
            {{Form::text('subject','',['class'=>'form-control border border-warning ','placeholder'=>'Subject'])}}
        </div>
        
        <div class="form-group">
                {{Form::label('description','Grievance Description')}}
                {{Form::textarea('description','',['class'=>'form-control border border-warning','placeholder'=>'Grievance Complaint'])}}

        </div>

        {{ Form::submit('Submit',['class'=>'btn btn-warning' ])}}
    

           
      
        
        {!! Form::close() !!}
    </div>
     
     @endsection
 