let searchInput = ""
let checkSearchCity = false
let checkSearchDistric = false
let checkXa = false

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
var mapDefaultZoom = 5;

var layerBG = new ol.layer.Tile({
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
var styleFunction = function (feature) {
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
    var strObjJson = createJsonObj(data[0]['geo']);
    var objJson = JSON.parse(strObjJson);
    //alert(JSON.stringify(objJson));
    //drawGeoJsonObj(objJson);
    highLightGeoJsonObj(strObjJson);
}

export const handleSearch = (e, location) => {
    searchInput = e.value;
    console.log(searchInput);
    $.ajax({
        type: "POST",
        url: "Gs_pgsqlAPI.php",
        //dataType: 'json',
        data: {
            functionname: 'getDataCityFromSearchToAjax',
            paPoint: searchInput
        },
        success: function (result) {
            highLightObj(result);
            // pop_up_inform(result)
            // alert("Ok")
        },
        error: function (req, status, error) {
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


export const valueSearch = searchInput;
export const checkLocationCity = checkSearchCity;
export const checkLocationDistric = checkSearchDistric;
export const checkLocalXa = checkXa;

export function initialize_map(location) {
    

    function pop_up_inform(result){
        let data = JSON.parse(result);
        document.getElementById("myModal").style.display = "block";
        if((location==="tp"&&(checkLocationCity||data[0]['name_1']==="Thanh Hóa"))|| (location === "quan"&& (checkLocationDistrci || data[0]['name_1']==="Nga Sơn"))){
            document.querySelector(".modal-content").innerHTML =
            `
            <div style="font-size:24px">Tuyệt vời! Nơi này có chứa bí kíp.</div>
            <p class="name_p">${data[0]['name_1']}</p>
            <a style="text-decoration:none; line-style:none; color: black; font-size:20px; display:block; width:100%; text-align:center;" href="Gs_hightlight_dicstrict.php"><button style:"width:100%;">Đại hiệp muốn tiếp tục di chuyển đến địa điểm này chứ ?</button></a>
            ` ;
        }

        else if(location==="xa"&&(checkXa|| data[0]['name_1'] === "Nga Trường")){
            document.querySelector(".modal-content").innerHTML =
            `
            <div style="font-size:24px">Chúc mừng đại hiệp đã tìm ra bí kíp võ công</div>
            <p class="name_p">Bí kíp được giấu ở: ${data[0]['name_1']}</p>
            <img src="https://cf.shopee.vn/file/00d8dc122e00d56a75349df8cd7a1b6f" style="width: 55px; height:75px;"/>
            ` ;
        }
        else{
            document.querySelector(".modal-content").innerHTML =
            `
            <div style="font-size:20px">Ôi không! Đại hiệp chọn sai mất rồi</div>
            <p class="name_p">${data[0]['name_1']}</p>
            <div style="font-size:20px">Đại hiệp vui lòng chọn lại địa điểm tìm kiếm (Gợi ý: ${location==="tp"?"Thanh Hóa":"Nga Sơn"})</div>
            ` ;    
        }
       
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
                functionname: 'getGeoCMRToAjax',
                paPoint: myPoint
            },
            success: function(result, status, erro) {
                console.log(result);
                highLightObj(result);
                pop_up_inform(result)
                // alert(result)
            },
            error: function(req, status, error) {
                alert(req + " " + status + " " + error);
            }
        });
        //*/
    });

};