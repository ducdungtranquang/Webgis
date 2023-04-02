let searchInput = ""
const checkSearchCity = false
const checkSearchDistric = false
export const handleSearch = (e, location)=>{
    searchInput = e.target.value;
    if(e.target.value === "Thanh Hóa" && location === "tp"){
        console.log("Success");
        checkSearchCity = true
    }
    else{
        checkSearch = false
    }
} 

export const valueSearch = searchInput;
export const checkLocationCity = checkSearchCity;
export const checkLocationDistric = checkSearchDistric;

export function initialize_map(format, map, mapLat, mapLng, mapDefaultZoom, layerBG, valueSearch) {
    
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

    function drawGeoJsonObj(paObjJson) {
        var vectorSource = new ol.source.Vector({
            features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            })
        });
        var vectorLayer = new ol.layer.Vector({
            source: vectorSource
        });
        map.addLayer(vectorLayer);
    }

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

    function highLightObj(result) {
        let data = JSON.parse(result);
        // console.log(data);
        var strObjJson = createJsonObj(data[0]['geo']);
        var objJson = JSON.parse(strObjJson);
        //alert(JSON.stringify(objJson));
        //drawGeoJsonObj(objJson);
        highLightGeoJsonObj(strObjJson);
    }

    function pop_up_inform(result){
        let data = JSON.parse(result);
        document.getElementById("myModal").style.display = "block";
        document.getElementById("myModal").innerHTML =data[0]['name_1'] ;
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
            url: "CMR_pgsqlAPI.php",
            //dataType: 'json',
            data: {
                functionname: 'getGeoCMRToAjax',
                paPoint: myPoint
            },
            success: function(result, status, erro) {
                highLightObj(result);
                pop_up_inform(result)
                // alert(result)
                console.log(result);
            },
            error: function(req, status, error) {
                alert(req + " " + status + " " + error);
            }
        });
        //*/
    });

    // map.on('pointermove', function(evt) {
    //     // alert("coordinate: " + evt.coordinate);
    //     //var myPoint = 'POINT(12,5)';
    //     var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
    //     var lon = lonlat[0];
    //     var lat = lonlat[1];
    //     var myPoint = 'POINT(' + lon + ' ' + lat + ')';
    //     //alert("myPoint: " + myPoint);
    //     //*
    //     $.ajax({
    //         type: "POST",
    //         url: "CMR_pgsqlAPI.php",
    //         //dataType: 'json',
    //         data: {
    //             functionname: 'getGeoCMRToAjax',
    //             paPoint: myPoint
    //         },
    //         success: function(result, status, erro) {
    //             // alert("test", result)
    //         },
    //         error: function(req, status, error) {
    //             alert(req + " " + status + " " + error);
    //         }
    //     });
    //     //*/
    // });
};