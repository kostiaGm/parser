<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Logs</title>
    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Logs</h3>
        </div>
        <div class="panel-body">


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sections load</h3>
                </div>
                <div class="panel-body">

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                            60%
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script src="/js/socket.io.js"></script>
<script>

    $(function () {
        var socket = io('http://localhost:2021');

        socket.emit("chat message", "Hello");
        socket.on("chat message", function(data) {
            console.log(data);
        })
      /*  socket.on('connect', function(){
            socket.send("hello")

        });
        socket.on('event', function(data){});
        socket.on('disconnect', function(){});*/
    });

</script>
</body>

</html> 