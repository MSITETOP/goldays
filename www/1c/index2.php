<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?
COption::SetOptionString("catalog", "DEFAULT_SKIP_SOURCE_CHECK", "Y"); 
COption::SetOptionString("sale", "secure_1c_exchange", "N"); 
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>