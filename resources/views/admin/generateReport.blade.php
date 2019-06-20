<!DOCTYPE html>
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






</head>
<body>
    
<div class="container box">
<form action="{{ route('grievance.report') }}" method="get" >

<div class="form-group">
<label for="fromDate">From:</label>
 <input type="date" name="fromDate" value="" class="form-group">
</div>



<div class="form-group">
<label for="toDate">To:</label>

  <input type="date" name="toDate"  value="" class="form-group">
</div>

<!-- DROPDOWN FOR CATEGORY I.E. DEPARTMENT-->

<select id="class_dropdown" class="custom-select custom-select-sm" style="height:40px; width:10%;" onclick="a(this)"  >
    <option value="0">Select a Category</option>
    <option value="1">Academic</option>
    <option value="2">Cleanliness</option>
    <option value="3">Infrastructure</option>
    <option value="4">Harassment</option>
    <option value="5">Disciplinary Action</option>
    
    
</select>   

<input type="hidden"  id="myLink" name="category"/>
<script>
  
  var a=function(el) {
     let  a=document.getElementById('class_dropdown');
           
        document.getElementById("myLink").value= a.options[a.selectedIndex].value;
     };
     
</script>




   
   <div class="form-group">
   <button type="submit" name="submit" value="submit" >Generate Report</button>

   </div>
    
  
</form>
</div>   
        <!-- {{-- <button id="tblEmployee" class="btn btn-danger">Export</button> --}} -->
        <div class="container">
        <a href="{{ route('grievance.generate',['type'=>'xls']) }}" class="btn btn-primary" style="margin-right: 15px;">Download - Excel xls</a>
        <a href="{{ route('grievance.generate',['type'=>'xlsx']) }}" class="btn btn-primary" style="margin-right: 15px;">Download - Excel xlsx</a>
        <a href="{{ route('grievance.generate',['type'=>'csv']) }}" class="btn btn-primary" style="margin-right: 15px;">Download - CSV</a>
        </div>
    <table  id="table2excel" class="table">
        <thead>
        <tr>
            <td colspan="5" >Date</td>
            <td colspan="3" >Grievance_id</td>
            <td colspan="5" >Sender</td>
            <td colspan="3" >Department</td>
            <td colspan="3" >Handler</td>
            <td colspan="3" >Grievance_out</td>
        </tr>
        </thead>
        @foreach($grevs as $grev)
        <tbody>
        <tr>
            <td colspan="5" >{{ Carbon\Carbon::parse($grev->created_at)->toDayDateTimeString() }}</td>
            <td colspan="3" >{{ $grev->id }}</td>
            <td colspan="5" >{{ $grev->user_email}}</td>
            <td colspan="3" >{{ $grev->category }}</td>
          
            <td colspan="3" >category mail</td>
            <td colspan="3" >{{ $grev->updated_at }}</td>
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

</body>
</html>