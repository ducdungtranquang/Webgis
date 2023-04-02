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
            width: 60%;
            min-height:200px ;
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

        .treasure-chest {}

        .treasure-chest img {
            position: absolute;
            display: block;
            width: 10%;
            bottom: 0;
        }

        .light img {
            position: absolute;
            display: block;
            width: 5%;
            top: 100;
            right: -10px;
        }

        .instruct {
            font-size: 30px;
            font-weight: 500;
            text-align: center;
        }

        .instruct-conten {
            font-weight: 500;
            font-size:24px;
        }
    </style>
    <!-- <script src="http://localhost:8081/libs/jquery/jquery-3.4.1.min.js" type="text/javascript"></script> -->
</head>

<body>
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
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <p class="instruct">Hướng dẫn chơi</p>
            <p class="instruct-conten">
                1. Xác định khu vực cụ thể bạn muốn tìm kiếm bí kíp, có thể là một thành phố, một tỉnh hoặc một khu vực
                nhất định. <br />

                2. Sử dụng chức năng tìm kiếm để nhập tên xã/phường hoặc tên tỉnh/thành phố vào ô tìm kiếm.<br />

                3. Khi tìm thấy vị trí đúng, bạn có thể phóng to bản đồ để xác định vị trí chính xác hơn.<br />

                4. Khi đã tìm được bí kíp, bạn có thể giấu nó bằng cách click vào rương bên dưới và viết một câu chuyện
                dài
                và hấp dẫn để thúc đẩy người khác tìm kiếm bí kíp của bạn. Hãy đảm bảo giữ bí kíp ở vị trí an toàn và
                không để lộ cho người khác biết.<br />
            </p>
        </div>

    </div>
    <div id="modalPassword" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <p class="instruct">Hướng dẫn chơi</p>
            <p class="instruct-conten">
                xin vui lòng cài mật khẩu
            </p>
            <div class="input-group">
                <input id="password" type="Password" class="form-control rounded" placeholder="Password" aria-label="Password" aria-describedby="search-addon" />
                <button id="savePass" type="button" class="btn btn-outline-primary">Save</button>
            </div>
        </div>

    </div>
    <div id="modalEnterPass" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <p class="instruct">Hướng dẫn chơi</p>
            <p class="instruct-conten">
                xin vui lòng nhập mật khẩu
            </p>
            <div class="input-group">
                <input id="enterPassword" type="Password" class="form-control rounded" placeholder="Password" aria-label="Password" aria-describedby="search-addon" />
                <button id="sendPass" type="button" class="btn btn-outline-primary">Save</button>
            </div>
        </div>

    </div>
    <div id="modalBiKip" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <p class="instruct">Bí Kíp</p>
            <p class="instruct-conten">
                quyển 1
            </p>
            <p class="instruct-conten">
                quyển 2
            </p>
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
        import {
            initialize_map,
            valueSearch,
            handleSearch
        } from './query.js'
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
        const location = "tp";

        initialize_map(format, map, mapLat, mapLng, mapDefaultZoom, valueSearch);
    </script>
    <script src="main.js"></script>

</body>

</html>