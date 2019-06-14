<html>
    <head></head>
        <body>
        <h2> Your report for the following grievance has been rejected:</h2>
        <p>

        <div class="container box">
            Grievance Subject:{{$grev->subject}}
            <br>
            Grievance Body:{{$grev->description}}
        </div>
        <hr>
        <h3>Reply from Admin:</h3>
        <p>
            {{$adminReply}}
        </p>

        </p>
        </body>
        </html>