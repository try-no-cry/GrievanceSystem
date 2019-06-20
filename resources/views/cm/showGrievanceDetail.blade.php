@extends('cm.cellnav')


@section('content')
@dump("cm.showGrievanceDetail.blade.php")

{{-- grv,id --}}


<div  style="margin-top:15px;">
        <label>Subject:</label>
        <p style="border:0.5px solid #343a40;border-radius:5px;maxwidth=100%;text-indent:4px;padding:4px;">{{$grvs->subject}}</p>
        <label for="textarea">Grievance/Suggestion</label>
        <p style="border:0.5px solid #343a40;border-radius:5px;maxwidth=100%;text-indent:4px;padding:4px;">{{$grvs->description}}</p>
        
 </div>

@endsection