<?$bAjaxMode = (isset($_POST["AJAX_POST"]) && $_POST["AJAX_POST"] == "Y");
if($bAjaxMode)
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	global $APPLICATION;
}?>
<?if((isset($arParams["IBLOCK_ID"]) && $arParams["IBLOCK_ID"]) || $bAjaxMode):?>
	<?
	if ($_POST["AJAX_PARAMS"] && !is_array(unserialize(urldecode($_POST["AJAX_PARAMS"]), ["allowed_classes" => false]))) {
		header('HTTP/1.1 403 Forbidden');
		$APPLICATION->SetTitle('Error 403: Forbidden');
		echo 'Error 403: Forbidden_1';
		require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');
		die();
	}
	$arIncludeParams = ($bAjaxMode ? $_POST["AJAX_PARAMS"] : $arParamsTmp);
	$arGlobalFilter = ($bAjaxMode ? unserialize(urldecode($_POST["GLOBAL_FILTER"]), ["allowed_classes" => false]) : ($_GET['GLOBAL_FILTER'] ? unserialize(urldecode($_GET['GLOBAL_FILTER']), ["allowed_classes" => false]) : array()));
	$arComponentParams = unserialize(urldecode($arIncludeParams), ["allowed_classes" => false]);
	$arComponentParams['TYPE_SKU'] = \Bitrix\Main\Config\Option::get('aspro.optimus', 'TYPE_SKU', 'TYPE_1', SITE_ID);
	?>

	<?
	if($bAjaxMode && (is_array($arGlobalFilter) && $arGlobalFilter))
		$GLOBALS[$arComponentParams["FILTER_NAME"]] = $arGlobalFilter;

	if($bAjaxMode && $_POST["FILTER_HIT_PROP"])
		$arComponentParams["FILTER_HIT_PROP"] = $_POST["FILTER_HIT_PROP"];

	/* hide compare link from module options */
	/*if (CNext::GetFrontParametrValue('CATALOG_COMPARE') == 'N') {
		$arComponentParams["DISPLAY_COMPARE"] = 'N';
	}*/
	/**/

	if ($_POST["ajax_get"] && $_POST["ajax_get"] === 'Y') {
		$arComponentParams["AJAX_REQUEST"] = 'Y';
	}
	// print_r($arComponentParams);
	?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"catalog_block_front",
		$arComponentParams,
		false, array("HIDE_ICONS"=>"Y")
	);?>

<?endif;?>