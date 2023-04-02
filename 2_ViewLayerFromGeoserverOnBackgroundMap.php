<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>The first webgis: View Layer From Geoserver On Background Map</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>

    <style>
        body {
            font-family: 'Dancing Script', cursive;
            background-image: url("./Screen\ Shot\ 2023-03-31\ at\ 09.50.54.png");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            overflow: hidden;
            position: relative;
        }

        .app {
            height: 100vh;
            width: 100%;
            position: relative;
        }

        .header {
            font-family: 'Dancing Script', cursive;
            font-size: 80px;
            text-align: center;
            color: rgb(124, 124, 17);
            font-weight: 700;
            background: rgba(255, 255, 255, .55);
            /* border-radius: 8px; */
            box-shadow: 0px 10px rgba(0, 0, 0, .2);
            margin-top: 10px;
        }

        .ban-do {
            height: 60vh;
            background-color: white;
            box-shadow: 0px 10px 10px 10px rgba(0, 0, 0, .2);
        }

        .ban-do-app {
            width: 60%;
            background-color: white;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translate(-50%);
        }

        .input-group {
            height: 30px;
        }

        .input-group input {
            font-size: 24px;

        }

        .input-group button {
            font-size: 30px;
        }

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #map {
            width: 100%;
            height: 100%;
            margin-top: 50px;
        }

        #map :hover {
            cursor: pointer;
        }

        .tool_tip {
            position: absolute;
            z-index: 100;
            display: block;
            background-color: #000;
            color: #fefefe;
            padding: 12px;
            border-radius: 3px;
            /* top: 10px;
    left: 50%; */
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }

        .hide_tool_tips {
            display: none;
        }
    </style>
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


    <script>
        var format = 'image/png';
        var map;
        var minX = 8.49874900000009;
        var minY = 1.65254800000014;
        var maxX = 16.1921150000001;
        var maxY = 13.0780600000001;
        var cenX = (minX + maxX) / 2;
        var cenY = (minY + maxY) / 2;
        var mapLat = cenY;
        var mapLng = cenX;
        var mapDefaultZoom = 6;

        function initialize_map() {
            //*
            layerBG = new ol.layer.Tile({
                source: new ol.source.OSM({})
            });
            //*/
            var layerCMR_adm1 = new ol.layer.Image({
                source: new ol.source.ImageWMS({
                    ratio: 1,
                    url: 'http://localhost:8080/geoserver/vietnam/wms?service=WMS&version=1.1.0&request=GetMap&layers=vietnam%3Agadm41_vnm_1&bbox=102.107955932617%2C8.30629730224609%2C109.505798339844%2C23.4677505493164&width=374&height=768&srs=EPSG%3A4326&styles=&format=application/openlayers',
                    params: {
                        'FORMAT': format,
                        'VERSION': '1.1.1',
                        STYLES: '',
                        LAYERS: 'vietnam:gadm41_vnm_1',
                    }
                })
            });
            var viewMap = new ol.View({
                center: ol.proj.fromLonLat([mapLng, mapLat]),
                zoom: mapDefaultZoom
                //projection: projection
            });
            map = new ol.Map({
                target: "map",
                layers: [layerBG, layerCMR_adm1],
                //layers: [layerCMR_adm1],
                view: viewMap
            });
        };
    </script>

    <script>
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        };

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
        const mapELement = document.querySelector("#map");
        const toolTip = document.querySelector(".tool_tip");

        mapELement.addEventListener("mousemove", e => {
            toolTip.classList.remove("hide_tool_tips");
            document.querySelector(".coordinateX").innerHTML = e.offsetX;
            document.querySelector(".coordinateY").innerHTML = e.offsetY;
            toolTip.style.top = e.offsetY + 12 + "px";
            toolTip.style.left = e.offsetX + "px";
        })

        mapELement.addEventListener('mouseleave', () => {
            toolTip.classList.add("hide_tool_tips");
        })
    </script>
</body>

</html>