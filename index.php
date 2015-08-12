<!DOCTYPE html>
<html>
<head>
    <title>Demo live</title>
    <link type="text/css" rel="stylesheet" href="css/stylesheet.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans Condensed:300italic,300,700" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript" src="js/jquery-1.11.2.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>

<body>
<header class="homebanner"> <h1 class="homebannertext">WEB POST FINDER</h1> </header>
<section>
    <div class="homesection">
        <div class="node">
            <input type="text" id="path" class="form-control"
                   placeholder="Please tell me the path to link web - just category"
                   style="margin: auto; width: 397px;"/>
        </div>
        <a title="Create" href="javascript:void(0);" onclick="fetchData();"
            <div id="little">fetch posts from the site</div>
            <div id="big">FIND NOW!!</div>
        </a>
    </div>
    <div style="padding-left: 25%;" id="resultDiv"></div>
</section>

<script type="text/javascript">
    function fetchData(){

    }
</script>
</body>
</html>