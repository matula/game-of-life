<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Conway's Game of Life in PHP, by Terry Matula">
    <meta name="author" content="Terry Matula">

    <title>Matula's Game of Life in PHP</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <style>
        table#game-grid {
            border-collapse: collapse;
        }

        table#game-grid td {
            border: 1px solid #999;
            width: 30px;
            height: 30px;
        }

        .alive {
            background: #3f4c6b; /* Old browsers */
            background: -moz-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3f4c6b), color-stop(100%, #545a68)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* IE10+ */
            background: linear-gradient(to bottom, #3f4c6b 0%, #545a68 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3f4c6b', endColorstr='#545a68', GradientType=0); /* IE6-9 */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h3 class="text-muted">Matula's Game of Life</h3>
    </div>
    <div class="row marketing">
        <div class="col-lg-12">
            An implementation of <a href="http://en.wikipedia.org/wiki/Conway's_Game_of_Life">Conway's Game of Life</a>
            in PHP just as a personal coding excercise.  It's all very procedural.<br>
            <a class="btn btn-primary" href="https://github.com/matula/game-of-life"><span style="color: #fff" class="glyphicon glyphicon-download-alt"></span> Github</a>
            <br><br>
        </div>
    </div>
    <div class="row marketing">

        <br><br>
        <div class="col-lg-12" id="game">

        </div>
        <br>

        <br>
        <div class="row">
        <a href="./clearsession.php" class="btn btn-default">Restart</a>
            </div>
    </div>

</div>
</div>
<script src="//code.jquery.com/jquery-2.1.0.min.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script>
    $(function() {
        var interval = 1000;   //number of mili seconds between each call
        var refresh = function() {
            $.ajax({
                url: "ajax.php",
                cache: false,
                success: function(html) {
                    $('#game').html(html);
                    setTimeout(function() {
                        refresh();
                    }, interval);
                }
            });
        };
        refresh();

//        $("#slider").slider({
//            value:1000,
//            min: 100,
//            max: 3000,
//            step: 100,
//            slide: function( event, ui ) {
//                $("#amount").val( (ui.value/1000) + ' seconds' );
//                refresh(ui.value);
//            }
//        });

    });
</script>
</body>
</html>