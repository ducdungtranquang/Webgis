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
            min-height: 200px;
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
            font-size: 24px;
        }

        .name_p {
            text-align: center;
            margin: auto;
            font-size: 30px;
        }

        .video_open {
            display: none;
        }

        #area{
            display: none;
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
                <input type="search" class="form-control rounded input_search" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button type="button" class="btn btn-outline-primary search_btn">search</button>
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
        <div class="modal-content md0">
        </div>
    </div>

    <div id="myModal1" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <p class="instruct">Hướng dẫn chơi</p>
            <p class="instruct-conten">
                1. Xác định khu vực cụ thể bạn muốn tìm kiếm bí kíp, theo thứ tự thành phố/tỉnh -> quận/huyện
                nhất định. <br />

                2. Sử dụng chức năng tìm kiếm để nhập tên xã/phường hoặc tên tỉnh/thành phố vào ô tìm kiếm.<br />

                3. Khi tìm thấy vị trí không đúng, bạn sẽ nhận được gợi ý và bạn phải chọn lại.<br />

                4. Khi đã tìm được bí kíp, bạn có thể tìm nó bằng cách click vào rương bên dưới, tạo và nhập mật khẩu để xem nhanh.<br />
            </p>
        </div>

    </div>
    <div id="modalPassword" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <p class="instruct">Bí kíp</p>
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
            <p class="instruct">Bí kíp</p>
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
            <a href="https://www.youtube.com/watch?v=Gta5-ELJtoQ" target="_blank">Link bí kíp</a>
        </div>

    </div>

    <div id="area" class="modal">
        <div class = "modal-content"></div>
    </div>

    <?php include 'Gs_pgsqlAPI.php' ?>
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
        const location = "quan";
        const minX = 104.367080688477;
        const minY = 19.2015438079834;
        const maxX = 106.158111572266;
        const maxY = 20.6779804229736;

        const searchInputEl = document.querySelector(".search_btn");
        let searchInput = ""
        let checkSearchCity = false
        let checkSearchDistric = false
        let checkXa = false

        var format = 'image/png';
        var map;
        var cenX = (minX + maxX) / 2;
        var cenY = (minY + maxY) / 2;
        var mapLat = cenY;
        var mapLng = cenX;
        var mapDefaultZoom = 8;

        var layerBG = new ol.layer.Tile({
            source: new ol.source.OSM({})
        });
        //*/
        var layerCMR_adm1 = new ol.layer.Image({
            source: new ol.source.ImageWMS({
                ratio: 1,
                url: 'http://localhost:8080/geoserver/vietnam/wms?service=WMS&version=1.1.0&request=GetMap&layers=vietnam%3Aboundary_thanhhoa&bbox=104.367080688477%2C19.2015438079834%2C106.158111572266%2C20.6779804229736&width=768&height=633&srs=EPSG%3A4326&styles=&format=application/openlayers',
                params: {
                    'FORMAT': format,
                    'VERSION': '1.1.1',
                    STYLES: '',
                    LAYERS: 'vietnam:boundary_thanhhoa',
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
        //map.getView().fit(bounds, map.getSize());

        var styles = {
            'MultiPolygon': new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'orange'
                }),
                stroke: new ol.style.Stroke({
                    color: 'yellow',
                    width: 2
                })
            })
        };
        var styleFunction = function(feature) {
            return styles[feature.getGeometry().getType()];
        };
        var vectorLayer = new ol.layer.Vector({
            //source: vectorSource,
            style: styleFunction
        });
        map.addLayer(vectorLayer);

        function highLightGeoJsonObj(paObjJson) {
            var vectorSource = new ol.source.Vector({
                features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
                    dataProjection: 'EPSG:4326',
                    featureProjection: 'EPSG:3857'
                })
            });
            vectorLayer.setSource(vectorSource);
            /*
            var vectorLayer = new ol.layer.Vector({
                source: vectorSource
            });
            map.addLayer(vectorLayer);
            */
        }

        function createJsonObj(result) {
            var geojsonObject = '{' +
                '"type": "FeatureCollection",' +
                '"crs": {' +
                '"type": "name",' +
                '"properties": {' +
                '"name": "EPSG:4326"' +
                '}' +
                '},' +
                '"features": [{' +
                '"type": "Feature",' +
                '"geometry": ' + result +
                '}]' +
                '}';
            return geojsonObject;
        }

        function highLightObj(result) {
            // alert("ok")
            let data = JSON.parse(result);
            // console.log(data);
            var strObjJson = createJsonObj(data[1]['st_asgeojson']);
            var objJson = JSON.parse(strObjJson);
            //alert(JSON.stringify(objJson));
            //drawGeoJsonObj(objJson);
            highLightGeoJsonObj(strObjJson);
        }

        const handleSearch = (e, location) => {
            searchInput = e.value;
            console.log(searchInput);
            

            $.ajax({
                    type: "POST",
                    url: "Gs_pgsqlAPI.php",
                    //dataType: 'json',
                    data: {
                        functionname: 'getInfoCMRToAjax',
                        paPoint: searchInput
                    },
                    success: function(result, status, erro) {
                        console.log(result);
                        const modalS = document.querySelector("#area")
                        modalS.style.display = "block";
                        modalS.querySelector(".modal-content").innerHTML = `<div style="text-align:center; margin:auto;"><p style="margin:"auto"; font-size:28px;">Diện tích huyện/quận ${searchInput} là: ${Number(JSON.parse(result)[0]['st_area'] * 10000).toFixed(4)} km2 </p>
                        <p style="margin:"auto"; font-size:28px;">Chu vi huyện/quận ${searchInput} là: ${Number(JSON.parse(result)[0]['st_perimeter'] * 100).toFixed(4)} km </p>
                        </div>
                        `

                    },
                    error: function(req, status, error) {
                        alert(req + " " + status + " " + error);
                    }
                });
            if (e.value === "Thanh Hóa" && location === "tp") {
                console.log("Success");
                checkSearchCity = true;
            }
            if (e.value === "Nga Sơn" && location === "quan") {
                console.log("Success");
                checkSearchDistric = true;
            }
            if (e.value === "Nga Trường" && location === "xa") {
                console.log("Success");
                checkXa = true;
            }
        }
        const valueSearch = searchInput;
        const checkLocationCity = checkSearchCity;
        const checkLocationDistric = checkSearchDistric;
        const checkLocalXa = checkXa;

        function initialize_map(location) {


            function pop_up_inform(result) {
                let data = JSON.parse(result);
                document.getElementById("myModal").style.display = "block";
                if ((location === "tp" && (checkLocationCity || data[1]['name'] === "Thanh Hóa"))) {
                    document.querySelector(".modal-content").innerHTML =
                        `
            <div style="font-size:24px">Tuyệt vời! Nơi này có chứa bí kíp.</div>
            <p class="name_p">${data[1]['name']}</p>
            <a style="text-decoration:none; line-style:none; color: black; font-size:20px; display:block; width:100%; text-align:center;" href="Gs_hightlight_dicstrict.php"><button style:"width:100%;">Đại hiệp muốn tiếp tục di chuyển đến địa điểm này chứ ?</button></a>
            `;
                } else if ((location === "quan" && (checkLocationDistric || data[1]['name'] === "Nga Sơn"))) {
                    document.querySelector(".modal-content").innerHTML =
                        `
            <div style="font-size:24px">Chúc mừng đại hiệp đã tìm ra bí kíp võ công</div>
            <p class="name_p">Bí kíp được giấu ở: ${data[1]['name']}</p>
            <img src="https://salt.tikicdn.com/cache/w1200/ts/product/6f/20/d7/861969b77c3307d04b997b476e53cde1.jpg" style="width: 75px; height:95px; margin:auto; margin-bottom:15px;"/>
            <button class = "btn_open" style="margin:auto;">Nhấn để mở bí kíp</buton>
            <iframe class="video_open" width="100%" height="300" src="https://www.youtube.com/embed/Gta5-ELJtoQ" title="Bí Kíp" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            `;
                } else {
                    document.querySelector(".modal-content").innerHTML =
                        `
            <div style="font-size:20px">Ôi không! Đại hiệp chọn sai mất rồi</div>
            <p class="name_p">${data[1]['name']}</p>
            <div style="font-size:20px">Đại hiệp vui lòng chọn lại địa điểm tìm kiếm (Gợi ý: ${location==="tp"?"Thanh Hóa":"Nga Sơn - Tiếp giáp Ninh Bình"})</div>
            `;
                }

                console.log(document.querySelector(".btn_open"));
                document.querySelector(".btn_open")?.addEventListener("click", () => {
                    localStorage.setItem("findBiKip", true)
                    console.log( document.querySelector(".video_open"));
                    document.querySelector(".video_open").style.display = "block";
                })

            }
            map.on('singleclick', async function(evt) {
                // alert("coordinate: " + evt.coordinate);z
                //var myPoint = 'POINT(12,5)';
                var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
                var lon = lonlat[0];
                var lat = lonlat[1];
                var myPoint = 'POINT(' + lon + ' ' + lat + ')';

                $.ajax({
                    type: "POST",
                    url: "Gs_pgsqlAPI.php",
                    //dataType: 'json',
                    data: {
                        functionname: 'getDataDistrictToAjax',
                        paPoint: myPoint
                    },
                    success: function(result, status, erro) {
                        console.log(result);
                        // highLightObj(result);
                        pop_up_inform(result)
                        // alert(result)
                        // console.log(result);

                    },
                    error: function(req, status, error) {
                        alert(req + " " + status + " " + error);
                    }
                });
                //*/
            });

        };

        searchInputEl.addEventListener("click", (e) => {
            handleSearch(document.querySelector(".input_search"), location)
        });
        initialize_map(location);
    </script>
    <script src="main.js"></script>

</body>

</html>