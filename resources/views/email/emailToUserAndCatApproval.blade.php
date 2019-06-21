<html>
    <head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


</head>
        <body>
        <h5 te> Grievance Solved</h5>
        <p>

        <div class="container box" style="padding-top:5px;background-color:rgba(0,0,0,.03);border:1px solid white;border-radius:15px">
		
                <div class="headEmail" style="margin-top:12px;padding-left:10px;padding-top:5px;background-color:#e0e0e0;border:1px solid white;border-radius:15px">                
                    <p style=""> <b>Grievance From:</b> &ensp;{{$grev->user_email}}</p>
               
           <b> <br>Grievance Subject</b>&ensp;{{$grev->subject}}
            <br>
            <br>
            </div>
		<hr style="height:1px;background-color:grey; width:90%;">
            <div class="bodyEmail" style="padding-left:10px;padding-top:5px;">
           <b> Grievance Body:</b> 
		<br><br>
           <p style="border-left: 5px solid grey; padding-left:15px;">
                
                        {{$adminReply}}
                
           </p>


            </div>
            <hr style="height:1px;background-color:grey; width:90%;">
        </div>
       

        {{-- <h3>Reply from Admin:</h3>
        <p>
            {{$adminReply}}
        </p> --}}

        </p>
        </body>
        </html>