@extends('layouts.app',['id'=>'1'])

@section('content')
@dump("auth.register.blade.php")
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-md-8" >
            <div class="card" style="border-radius:20px;">
                <div class="card-header" style="background-color:blue; color:white;">{{ __('Register') }}</div>

                <div class="card-body" >
                    <form method="POST" action="{{ route('register') }}">
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
                            <label for="class" class="col-md-4 col-form-label text-md-right">{{ __('Class:') }}</label>

                            <div class="col-md-6">
                                {{-- <input id="class" style="width:50%;" type="text" class="form-control{{ $errors->has('class') ? ' is-invalid' : '' }}" name="class" value="{{ old('class') }}" required autofocus> --}}


                                
    
       <select id="class_dropdown" class="custom-select custom-select-sm" style="height:40px;" onclick="a(this)"  >
        <option value="">Select Your Class</option>
        <option value="">Teacher</option>
         <option value="">D1A</option>
         <option value="">D1B</option>
         <option value="">D2A</option>
         <option value="">D2B</option>
         <option value="">D2C</option>
         <option value="">D3</option>
         <option value="">D4A</option>
         <option value="">D4B</option>
         <option value="">D5</option>
   
   
         <option value="">D6A</option>
         <option value="">D6B</option>
         <option value="">D7A</option>
         <option value="">D7B</option>
         <option value="">D7C</option>
         <option value="">D8</option>
         <option value="">D9A</option>
         <option value="">D9B</option>
         <option value="">D9C</option>
         <option value="">D10</option>
        
   
         <option value="">D11A</option>
         <option value="">D11B</option>
         <option value="">D12A</option>
         <option value="">D12B</option>
         <option value="">D12C</option>
         <option value="">D13</option>
         <option value="">D14A</option>
         <option value="">D14B</option>
         <option value="">D14C</option>
         <option value="">D15</option>
   
         <option value="">D16A</option>
         <option value="">D16B</option>
         <option value="">D17A</option>
         <option value="">D17B</option>
         <option value="">D17C</option>
         <option value="">D18</option>
         <option value="">D19A</option>
         <option value="">D19B</option>
         <option value="">D19C</option>
         <option value="">D20</option>
       </select>
   </div>


   <input type="hidden" 
   id="myLink"
  
  name="class"/>
   <script>
     
     var a=function(el) {
        let  a=document.getElementById('class_dropdown');
              if(a.options[a.selectedIndex].text !="Select Your Class")
                     document.getElementById("myLink").value= a.options[a.selectedIndex].text;
              else{
                
                   return;
              }       
        };
        
        </script>











                                @if ($errors->has('class'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                @endif
                            </div>
                        {{-- </div> --}}

                        <!-- Example single danger button -->

  


                          
                        <div class="form-group row">
                            <label for="roll_no" class="col-md-4 col-form-label text-md-right">{{ __('Roll No./ Staff ID:') }}</label>

                            <div class="col-md-6">
                                <input id="class" type="text" class="form-control{{ $errors->has('roll_no') ? ' is-invalid' : '' }}" name="roll_no" value="{{ old('roll_no') }}" required autofocus>

                                @if ($errors->has('roll_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('roll_no') }}</strong>
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
                                <button type="submit" class="btn btn-outline-success">
                                    {{ __('Register') }}
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
