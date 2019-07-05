{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
  <script src="/js/table2excel.js" type="text/javascript"></script>  
<style>
    body{
        padding:0px;
        margin:0px;
    }
    </style>





</head>
<body> --}}
    @extends('admin.adminnav',['id'=>'4'])
    @section('grievances')


<div class="container">



<form action="{{ route('grievance.report') }}" method="get" >
<div class="row" style="margin-top:30px;border:0.4px solid black;border-radius:10px;text:center;">

    <div class="col-lg-3" style="">

<label for="fromDate" style="">From:</label>
 <input type="date" name="fromDate" value="{{ old('fromDate') }}" style="padding-left:5px;">
</div>
 


<div class="col-lg-3" style="">

<label for="toDate" style="">To:</label>

  <input type="date" name="toDate"  value="{{ old('toDate') }}">
</div>


<!-- DROPDOWN FOR CATEGORY I.E. DEPARTMENT-->
{{-- custom-select custom-select-sm --}}

<div class="col-lg-3" style="">

<select id="class_dropdown" class="btn btn-secondary dropdown-toggle bg-light" style="font-size:19px;width:0100%;color:black;" onclick="a(this)"  >
    <option value="0">Select a Category</option>
    <option value="1">Academic</option>
    <option value="2">Cleanliness</option>
    <option value="3">Infrastructure</option>
    <option value="4">Harassment</option>
    <option value="5">Disciplinary Action</option>
    
    
</select>   
</div>

<input type="hidden"  id="myLink" name="category"/>
<script>
  
  var a=function(el) {
     let  a=document.getElementById('class_dropdown');
           
        document.getElementById("myLink").value= a.options[a.selectedIndex].value;
     };
     
</script>




<div class="col-lg-3" style="">
   <div style="">
  
   <button type="submit" name="submit" value="submit" class="btn btn-success" style="height:50%; width:100%;font-size:16px;">Generate Report</button>

   </div>
</div>

    <br>
    <br>
  
</form>
</div>

</div>   
        <!-- {{-- <button id="tblEmployee" class="btn btn-danger">Export</button> --}} -->
        <div class="container" style="margin-top:10px; text-align:center;">
        <a href="{{ route('grievance.generate',['type'=>'xls']) }}" class="btn btn-primary" style="margin-right: 15px;height:40px; width:20%;font-size:19px;">Download - Excel xls</a>
        <a href="{{ route('grievance.generate',['type'=>'xlsx']) }}" class="btn btn-primary" style="margin-right: 15px;height:40px; width:20%;font-size:19px;">Download - Excel xlsx</a>
        <a href="{{ route('grievance.generate',['type'=>'csv']) }}" class="btn btn-primary" style="margin-right: 15px;height:40px; width:20%;font-size:19px;">Download - CSV</a>
        </div>
        {{-- <br> --}}
    <table  id="table2excel" class="table table-striped table-hover" style="margin-top:10px;">
        <thead>
        <tr>
            <td colspan="5" >Date</td>
            <td colspan="3">Grievance_id</td>
            <td colspan="8">Solution</td>
            <td colspan="5" >Sender</td>
            <td colspan="4" >Department</td>
            <td colspan="4" >Handler</td>
            <td colspan="5">Grievance_out</td>
        </tr>
        </thead>
        @foreach($grevs as $grev)
        @dd( $report->where('gr_id', $grev->id)[])
        <?php
       $i=0;
$cat_number=$grev->category;
switch($cat_number){
    case 1:
            $a="Academics";
            
            break;

    case 2:
            $a="Cleanliness";
            break;
     case 3:
            $a="Infrastructure";
            break;
     case 4:
            $a="Harassment";
            break;
     case 5:
            $a="Disciplinary Action";
            break;
}
?>
        <tbody>
        <tr>
            <td colspan="5">{{ Carbon\Carbon::parse($grev->created_at)->toDayDateTimeString() }}</td>
            <td colspan="3" >{{ $grev->id }}</td>
            <td colspan="8" >{{  $report->where('gr_id', $grev->id)->get()}}</td>
            <td colspan="5" >{{ $grev->user_email}}</td>
            <td colspan="4" >{{$a}}</td>
        <td colspan="4" >{{$cat_number}}</td>
            <td colspan="5">{{ Carbon\Carbon::parse($grev->updated_at)->toDayDateTimeString()  }}</td>
        </tr>
        </tbody>
        @endforeach
    </table>


    <script>
    $("#table2excel").table2excel({    
            exclude: ".excludeThisClass",    
            name: "Worksheet Name",    
            filename: "SomeFile" //do not include extension    
        });   </script>

    <!-- <input type="button" id="btnExporttoExcel" value="Export To Excel" />   -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>  
    <script src="js/table2excel.js" type="text/javascript"></script>  
    <script type="text/javascript">

        $(function () {  
            $("#btnExporttoExcel").click(function () {  
                $("#tblEmployee").table2excel({  
                    filename: "Your_File_Name.xls"  
                });  
            });  
        });  
    </script> 
@endsection
{{-- </body>
</html> --}}