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

                    
                    for($i=0;$i<$no_of_reports;$i++){
                        if($report[$i]->gr_id==$grev->id){
                            echo $report[$i]->description;
                        }
                    }
                
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