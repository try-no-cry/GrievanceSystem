@extends('admin.adminnav',['id'=>'10'])

@section('grievances')
@dump("admin.addMember.blade.php")
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-md-8" >
            <div class="card" style="border-radius:20px;">
                <div class="card-header" style="background-color:blue; color:white;">{{ __('Register') }}</div>

                <div class="card-body" >
                    <form method="POST" action="{{ route('admin.addMemberBtn') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name:') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        
                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('SurName:') }}</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        
                        <div class="form-group row">
                            <label for="class" class="col-md-4 col-form-label text-md-right">{{ __('Category (if cell member):') }}</label>

                            <div class="col-md-6">
                                {{-- <input id="class" style="width:50%;" type="text" class="form-control{{ $errors->has('class') ? ' is-invalid' : '' }}" name="class" value="{{ old('class') }}" required autofocus> --}}


                                
    
       <select id="class_dropdown" class="" style="height:40px;" onclick="a(this)"  >
        <option value="">Select Category</option>
        <option value="">Academics</option>
         <option value="">Cleanliness</option>
         <option value="">Infrastructure</option>
         <option value="">Harrasment</option>
         <option value="">Disciplinary Action</option>
         <option value="">SC/ST related issue</option>
        
       </select>
   </div>


   <input type="hidden" 
   id="myLink"
  
  name="category"/>
   <script>
     
     var a=function(el) {
        let  a=document.getElementById('class_dropdown');
              if(a.options[a.selectedIndex].text !="Select Category")
                     document.getElementById("myLink").value= a.options[a.selectedIndex].text;
              else{
                
                   return;
              }       
        };
        
        </script>











                                @if ($errors->has('category'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        {{-- </div> --}}
{{-- name
namebutton -->
name
name --}}


                          
                        <div class="form-group row">
                            <label for="staffID" class="col-md-4 col-form-label text-md-right">{{ __(' Staff ID:') }}</label>

                            <div class="col-md-6">
                                <input id="class" type="text" class="form-control{{ $errors->has('staffID') ? ' is-invalid' : '' }}" name="staffID" value="{{ old('staffID') }}" required autofocus>

                                @if ($errors->has('staffID'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('staffID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn-grad float-left " name="submit" value="asCategory">
                                   <small> {{ __('Register Cell-Member') }}</small>
                                </button>
                                <button type="submit" class="btn-grad float-right" name="submit" value="asAdmin">
                                   <small> {{ __('Register Admin') }}</small>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
