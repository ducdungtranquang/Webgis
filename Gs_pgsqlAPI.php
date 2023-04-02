<?php
    if(isset($_POST['functionname']))
    {
        $paPDO = initDB();
        $paSRID = '4326';
        $paPoint = $_POST['paPoint'];
        $functionname = $_POST['functionname'];
        $aResult = "null";
        //Khai báo điều kiện
        if ($functionname == 'getGeoCMRToAjax')
            $aResult = getGeoCMRToAjax($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getInfoCMRToAjax')
            $aResult = getInfoCMRToAjax($paPDO, $paPoint);
        else if($functionname == 'getDataCityFromSearchToAjax')
            $aResult = getDataCityFromSearchToAjax($paPDO, $paPoint);
        else if($functionname == "getDataDistrictToAjax"){
            $aResult = getDataDistrictToAjax($paPDO, $paSRID, $paPoint);
        }
        echo $aResult;
        closeDB($paPDO);
    }

    function initDB()
    {
        // Kết nối CSDL
        $paPDO = new PDO('pgsql:host=localhost;dbname=vietnamgadm;port=5432', 'postgres', '123456');
        return $paPDO;
    }
    function query($paPDO, $paSQLStr)
    {
        try
        {
            // Khai báo exception
            $paPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Sử đụng Prepare 
            $stmt = $paPDO->prepare($paSQLStr);
            // Thực thi câu truy vấn
            $stmt->execute();
            
            // Khai báo fetch kiểu mảng kết hợp
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            // Lấy danh sách kết quả
            $paResult = $stmt->fetchAll();   
            return $paResult;                 
        }
        catch(PDOException $e) {
            echo "Thất bại, Lỗi: " . $e->getMessage();
            return null;
        }       
    }
    function closeDB($paPDO)
    {
        // Ngắt kết nối
        $paPDO = null;
    }

    // Lấy thông tin từ Search và trả ra vùng(Thành phố)
    function getDataCityFromSearchToAjax($paPDO,$paPoint){
        $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo from \"gadm41_vnm_1\" where name_1 = '$paPoint'";
        $result = query($paPDO, $mySQLStr);
        
        if ($result != null)
        {
            return json_encode($result);
        }
        else
            return "null";
        
    }


    //Lấy ra vùng được truy vấn (Click vào thành phố/tỉnh)
    function getGeoCMRToAjax($paPDO,$paSRID,$paPoint)
    {
        $paPoint = str_replace(',', ' ', $paPoint);
        $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo, name_1  from \"gadm41_vnm_1\" where ST_Within('SRID=".$paSRID.";".$paPoint."'::geometry,geom)";
        $result = query($paPDO, $mySQLStr);
        
        if ($result != null)
        {
            return json_encode($result);
        }
        else
            return "null";
    }

    //Lấy ra Tên của huyện/quận được click
    function getDataDistrictToAjax($paPDO,$paSRID,$paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
        $mySQLStr = "SELECT name from \"boundary_thanhhoa\" where ST_Within('SRID=".$paSRID.";".$paPoint."'::geometry,geom)";
        $result = query($paPDO, $mySQLStr);
        
        if ($result != null)
        {
            return json_encode($result);
        }
        else
            return "null";
    }

    //Lấy ra Chu vi, S của vùng được tìm kiếm
    function getInfoCMRToAjax($paPDO,$paPoint)
    {
        $mySQLStr = "SELECT ST_AREA(geom), ST_PERIMETER(geom) from \"boundary_thanhhoa\" where name = '$paPoint' ";
        $result = query($paPDO, $mySQLStr);
        
        if ($result != null)
        {
            return json_encode($result);
        }
        else
            return "hello";
    }
