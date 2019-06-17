<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  
  <script>
      function exportToExcel(tableID, filename = ''){
    var downloadurl;
    var dataFileType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTMLData = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'export_excel_data.xls';
    
    // Create download link element
    downloadurl = document.createElement("a");
    
    document.body.appendChild(downloadurl);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTMLData], {
            type: dataFileType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadurl.href = 'data:' + dataFileType + ', ' + tableHTMLData;
    
        // Setting the file name
        downloadurl.download = filename;
        
        //triggering the function
        downloadurl.click();
    }
}
      </script>

</head>
<body>
    <a href="#" id="test" onclick="javascript:fnExcelReport();">Download</a>

    <table  id="tblexportData" class="table">
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
    <button onclick="exportToExcel('tblexportData', 'user-data')" class="btn btn-success">Export Table Data To Excel File</button>
    
</body>
</html>