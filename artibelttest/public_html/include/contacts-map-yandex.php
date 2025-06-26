<?

$arPlacemarks[] = array(
    "ID" => 15207,
    "LON" => 39.693067,
    "LAT" => 47.271981,
    "TEXT" => "",
    "HTML" => ""
);

$APPLICATION->IncludeComponent(
    "bitrix:map.yandex.view",
    "map",
    array(
        "INIT_MAP_TYPE" => "ROADMAP",
        "MAP_DATA" => serialize(array("yandex_lat" => 47.271981, "yandex_lon" => 39.693067, "yandex_scale" => 17, "PLACEMARKS" => $arPlacemarks)),
        "MAP_WIDTH" => "100%",
        "MAP_HEIGHT" => "400",
        "CONTROLS" => array(
            0 => "ZOOM",
            1 => "SMALLZOOM",
            3 => "TYPECONTROL",
            4 => "SCALELINE",
        ),
        "OPTIONS" => array(
            0 => "ENABLE_DBLCLICK_ZOOM",
            1 => "ENABLE_DRAGGING",
        ),
        "MAP_ID" => "",
        "ZOOM_BLOCK" => array(
            "POSITION" => "right center",
        ),
        "COMPONENT_TEMPLATE" => "map",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO"
    ),
    false, array("HIDE_ICONS" =>"Y")
);
?>