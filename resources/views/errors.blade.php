
        @if($errors->count())
          <div class="alert alert-danger form-group" style="margin-top:10px;">
          @foreach ($errors->all() as $error )
          <ul>
              <li> {{ $error }}</li>
          </ul>
             
              
          @endforeach
        </div>
        @endif
 