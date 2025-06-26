<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;

Loader::includeModule('iblock');

$productsObj = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 87), false, false, array('ID', 'PROPERTY_CML2_MANUFACTURER', 'PREVIEW_TEXT'));
$params = array(
    "max_len" => "100", // обрезает символьный код до 100 символов
    "change_case" => "L", // буквы преобразуются к нижнему регистру
    "replace_space" => "_", // меняем пробелы на нижнее подчеркивание
    "replace_other" => "_", // меняем левые символы на нижнее подчеркивание
    "delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
    "use_google" => "false", // отключаем использование google
);
while ($productAr = $productsObj->GetNext()) {

    $previewText = $productAr['PREVIEW_TEXT'];
    $brandName = $productAr['PROPERTY_CML2_MANUFACTURER_VALUE'];
    if (!empty($brandName)) {
        $brandObj = CIBlockElement::GetList(array(), array('NAME' => $brandName, 'IBLOCK_ID' => 82), false, false, array('ID', 'NAME'));
        $brandAr = $brandObj->GetNext();
        if (!empty($brandAr['ID'])) {
            $brandID = $brandAr['ID'];
        } else {
            $el = new CIBlockElement;

            $addBrandAr = array(
                "CODE" => CUtil::translit($brandName, "ru", $params),
                "IBLOCK_ID" => 82,
                "NAME" => $brandName,
                "ACTIVE" => "Y",
            );
            $brandID = $el->Add($addBrandAr);
        }
        CIBlockElement::SetPropertyValuesEx($productAr['ID'], false, array(678 => $brandID));
    }

    $el = new CIBlockElement;
    ?>

    <pre>
        <? print_r($productAr) ?>
    </pre>
    <?php
    $updateProductAr = array(
        'NAME' => trim(str_replace(array('&nbsp;', '&#40;', '&#41;'), array(' ', '(', ')'), $previewText))
    );
    $res = $el->Update($productAr['ID'], $updateProductAr);

    $res = $el->Update($productAr['ID'], array());
//
//    $updateProductAr = array(
//        "MODIFIED_BY"    => $USER->GetID(),
//    );

//    $res = $el->Update($productAr['ID'], $updateProductAr);

}