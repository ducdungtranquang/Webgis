<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OpenStreetMap &amp; OpenLayers - Marker Example</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

    <!-- <link rel="stylesheet" href="http://localhost:8081/libs/openlayers/css/ol.css" type="text/css" />
        <script src="http://localhost:8081/libs/openlayers/build/ol.js" type="text/javascript"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>

    <!-- <script src="http://localhost:8081/libs/jquery/jquery-3.4.1.min.js" type="text/javascript"></script> -->
</head>

<body onload="initialize_map();">
    <div class="app">
        <div class="header">Giang Sơn Map</div>
        <div class="ban-do-app" style=" border: 3px solid black;
        border-radius: 5px;">
            <div class="input-group">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button type="button" class="btn btn-outline-primary">search</button>
            </div>

            <div class="ban-do" style="position: relative;">
                <div id="map"></div>
                <div class="tool_tip hide_tool_tips">
                    <div>Information</div>
                    <div>X: <span class="coordinateX"></span></div>
                    <div>Y: <span class="coordinateY"></span></div>
                </div>
            </div>

        </div>
                <div class="light">
            <img src="./—Pngtree—yellow creative bulb team idea_3847872.png" alt="">
        </div>
        <div class="treasure-chest">
            <img src="./—Pngtree—golden brown shiny treasure chest_6042838.png" alt="">
        </div>

    </div>

    <!-- Trigger/Open The Modal -->
    <button id="myBtn">Open Modal</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Some text in the Modal..</p>
        </div>

    </div>
    </div>
    <?php include 'CMR_pgsqlAPI.php' ?>
    <?php
    //$myPDO = initDB();
    //$mySRID = '4326';
    //$pointFormat = 'POINT(12,5)';

    //example1($myPDO);
    //example2($myPDO);
    //example3($myPDO,'4326','POINT(12,5)');
    //$result = getResult($myPDO,$mySRID,$pointFormat);

    //closeDB($myPDO);
    ?>
    <script type="module">
        import {initialize_map} from './query.js'
        var format = 'image/png';
        var map;
        var minX = 102.107955932617;
        var minY = 8.30629730224609;
        var maxX = 109.505798339844;
        var maxY = 23.4677505493164;
        var cenX = (minX + maxX) / 2;
        var cenY = (minY + maxY) / 2;
        var mapLat = cenY;
        var mapLng = cenX;
        var mapDefaultZoom = 6;
        
        initialize_map(format, map, mapLat, mapLng, mapDefaultZoom );

       
    </script>
    <script src="main.js"></script>
</body>

</html>