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
<div id="modalPassword" class="modal">

<!-- Modal content -->
<div class="modal-content">
    <p class="instruct">Hướng dẫn chơi</p>
    <p class="instruct-conten">
        xin vui lòng cài mật khẩu
    </p>
    <div class="input-group">
        <input id="password" type="Password" class="form-control rounded" placeholder="Password"
            aria-label="Password" aria-describedby="search-addon" />
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
        <input id="enterPassword" type="Password" class="form-control rounded" placeholder="Password"
            aria-label="Password" aria-describedby="search-addon" />
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
        import {initialize_map,valueSearch, handleSearch} from './query.js'
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
        
        initialize_map(format, map, mapLat, mapLng, mapDefaultZoom, valueSearch );

        // function initialize_map() {
        //     //*
        //     layerBG = new ol.layer.Tile({
        //         source: new ol.source.OSM({})
        //     });
        //     //*/
        //     var layerCMR_adm1 = new ol.layer.Image({
        //         source: new ol.source.ImageWMS({
        //             ratio: 1,
        //             url: 'http://localhost:8080/geoserver/vietnam/wms?service=WMS&version=1.1.0&request=GetMap&layers=vietnam%3Agadm41_vnm_1&bbox=102.107955932617%2C8.30629730224609%2C109.505798339844%2C23.4677505493164&width=374&height=768&srs=EPSG%3A4326&styles=&format=application/openlayers',
        //             params: {
        //                 'FORMAT': format,
        //                 'VERSION': '1.1.1',
        //                 STYLES: '',
        //                 LAYERS: 'vietnam:gadm41_vnm_1',
        //             }
        //         })
        //     });
        //     var viewMap = new ol.View({
        //         center: ol.proj.fromLonLat([mapLng, mapLat]),
        //         zoom: mapDefaultZoom
        //         //projection: projection
        //     });
        //     map = new ol.Map({
        //         target: "map",
        //         layers: [layerBG, layerCMR_adm1],
        //         //layers: [layerCMR_adm1],
        //         view: viewMap
        //     });
        //     //map.getView().fit(bounds, map.getSize());

        //     var styles = {
        //         'MultiPolygon': new ol.style.Style({
        //             fill: new ol.style.Fill({
        //                 color: 'orange'
        //             }),
        //             stroke: new ol.style.Stroke({
        //                 color: 'yellow',
        //                 width: 2
        //             })
        //         })
        //     };
        //     var styleFunction = function(feature) {
        //         return styles[feature.getGeometry().getType()];
        //     };
        //     var vectorLayer = new ol.layer.Vector({
        //         //source: vectorSource,
        //         style: styleFunction
        //     });
        //     map.addLayer(vectorLayer);

        //     function createJsonObj(result) {
        //         var geojsonObject = '{' +
        //             '"type": "FeatureCollection",' +
        //             '"crs": {' +
        //             '"type": "name",' +
        //             '"properties": {' +
        //             '"name": "EPSG:4326"' +
        //             '}' +
        //             '},' +
        //             '"features": [{' +
        //             '"type": "Feature",' +
        //             '"geometry": ' + result +
        //             '}]' +
        //             '}';
        //         return geojsonObject;
        //     }

        //     function drawGeoJsonObj(paObjJson) {
        //         var vectorSource = new ol.source.Vector({
        //             features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
        //                 dataProjection: 'EPSG:4326',
        //                 featureProjection: 'EPSG:3857'
        //             })
        //         });
        //         var vectorLayer = new ol.layer.Vector({
        //             source: vectorSource
        //         });
        //         map.addLayer(vectorLayer);
        //     }

        //     function highLightGeoJsonObj(paObjJson) {
        //         var vectorSource = new ol.source.Vector({
        //             features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
        //                 dataProjection: 'EPSG:4326',
        //                 featureProjection: 'EPSG:3857'
        //             })
        //         });
        //         vectorLayer.setSource(vectorSource);
        //         /*
        //         var vectorLayer = new ol.layer.Vector({
        //             source: vectorSource
        //         });
        //         map.addLayer(vectorLayer);
        //         */
        //     }

        //     function highLightObj(result) {
        //         let data = JSON.parse(result);
        //         // console.log(data);
        //         var strObjJson = createJsonObj(data[0]['geo']);
        //         var objJson = JSON.parse(strObjJson);
        //         //alert(JSON.stringify(objJson));
        //         //drawGeoJsonObj(objJson);
        //         highLightGeoJsonObj(strObjJson);
        //     }

        //     function pop_up_inform(result){
        //         let data = JSON.parse(result);
        //         document.getElementById("myModal").style.display = "block";
        //         document.getElementById("myModal").innerHTML =data[0]['name_1'] ;
        //     }
        //     map.on('singleclick', async function(evt) {
        //         // alert("coordinate: " + evt.coordinate);z
        //         //var myPoint = 'POINT(12,5)';
        //         var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
        //         var lon = lonlat[0];
        //         var lat = lonlat[1];
        //         var myPoint = 'POINT(' + lon + ' ' + lat + ')';
                
        //          $.ajax({
        //             type: "POST",
        //             url: "CMR_pgsqlAPI.php",
        //             //dataType: 'json',
        //             data: {
        //                 functionname: 'getGeoCMRToAjax',
        //                 paPoint: myPoint
        //             },
        //             success: function(result, status, erro) {
        //                 highLightObj(result);
        //                 pop_up_inform(result)
        //                 // alert(result)
        //                 console.log(result);
        //             },
        //             error: function(req, status, error) {
        //                 alert(req + " " + status + " " + error);
        //             }
        //         });
        //         //*/
        //     });

        //     // map.on('pointermove', function(evt) {
        //     //     // alert("coordinate: " + evt.coordinate);
        //     //     //var myPoint = 'POINT(12,5)';
        //     //     var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
        //     //     var lon = lonlat[0];
        //     //     var lat = lonlat[1];
        //     //     var myPoint = 'POINT(' + lon + ' ' + lat + ')';
        //     //     //alert("myPoint: " + myPoint);
        //     //     //*
        //     //     $.ajax({
        //     //         type: "POST",
        //     //         url: "CMR_pgsqlAPI.php",
        //     //         //dataType: 'json',
        //     //         data: {
        //     //             functionname: 'getGeoCMRToAjax',
        //     //             paPoint: myPoint
        //     //         },
        //     //         success: function(result, status, erro) {
        //     //             // alert("test", result)
        //     //         },
        //     //         error: function(req, status, error) {
        //     //             alert(req + " " + status + " " + error);
        //     //         }
        //     //     });
        //     //     //*/
        //     // });
        // };
    </script>
    <script src="main.js"></script>
</body>

</html>