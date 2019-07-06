
    @extends('admin.adminnav',['id'=>'6'])
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
            {{-- @dd($report[0]->description) --}}
            
            @foreach($grevs as $grev)
           
            <?php
           $no_of_reports= count($report);
           
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
        case 5:
                $a="SC/ST related issue";
                break;       
        }
        ?>
            <tbody>
            <tr>
                <td colspan="5">{{ Carbon\Carbon::parse($grev->created_at)->toDayDateTimeString() }}</td>
                <td colspan="3" >{{ $grev->id }}sdv</td>
                <td colspan="8" >
                    <?php
        
                            $check=0;
                            for($i=0;$i<$no_of_reports;$i++){
                                if($report[$i]->gr_id==$grev->id){
                                    $check=1;
                                    echo $report[$i]->description;
                                }
                            }

                            if($check==0)
                                echo "<small>Pending to be Approved by Admin</small>";
                        
                    ?>
                </td>
        
                <td colspan="5" >{{ $grev->user_email}}</td>
                <td colspan="4" >{{$a}}</td>
            <td colspan="4" >{{$cat_number}}</td>
                <td colspan="5">{{ Carbon\Carbon::parse($grev->updated_at)->toDayDateTimeString() }}</td>
            </tr>
            </tbody>
            @endforeach
        </table>


@endsection
