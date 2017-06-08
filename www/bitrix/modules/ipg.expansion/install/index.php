<?
IncludeModuleLangFile(__FILE__);

if (class_exists("ipg_expansion"))
	return;

class ipg_expansion extends CModule
{
	var $MODULE_ID = "ipg.expansion";
	var $MODULE_LANG_PREFIX = "IPG_EXPANSION_";
	var $MODULE_STRUCTURE = "\\IPG\\Expansion";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = $this->GetMessage("INSTALL_NAME");
		$this->MODULE_DESCRIPTION = $this->GetMessage("INSTALL_DESCRIPTION");

        $this->PARTNER_NAME = $this->GetMessage("PARTNER_NAME");
        $this->PARTNER_URI = $this->GetMessage("PARTNER_URI");
	}

    function GetMessage($name) {
        return GetMessage($this->MODULE_LANG_PREFIX . $name);
    }

	function InstallDB()
	{
		global $DB;

		//$DB->RunSQLBatch(dirname(__FILE__)."/sql/install.sql");

		RegisterModule($this->MODULE_ID);

		RegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", $this->MODULE_ID, $this->MODULE_STRUCTURE . "\\Init", "ATTRIBUTES2PROP");
		RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", $this->MODULE_ID, $this->MODULE_STRUCTURE . "\\Init", "ATTRIBUTES2PROP");
		RegisterModuleDependences("catalog", "OnSuccessCatalogImport1C", $this->MODULE_ID, $this->MODULE_STRUCTURE . "\\Init", "CatalogImport1CComplete");

		return true;
	}

	function UnInstallDB()
	{
		global $DB;

		//$DB->RunSQLBatch(dirname(__FILE__)."/sql/uninstall.sql");

        COption::RemoveOption($this->MODULE_ID);
        UnRegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", $this->MODULE_ID, $this->MODULE_STRUCTURE . "\\Init", "ATTRIBUTES2PROP");
        UnRegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", $this->MODULE_ID, $this->MODULE_STRUCTURE . "\\Init", "ATTRIBUTES2PROP");
        UnRegisterModuleDependences("catalog", "OnSuccessCatalogImport1C", $this->MODULE_ID, $this->MODULE_STRUCTURE . "\\Init", "CatalogImport1CComplete");

		UnRegisterModule($this->MODULE_ID);

		return true;
	}

	function InstallFiles()
	{
		//CopyDirFiles(dirname(__FILE__)."/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
		//CopyDirFiles(dirname(__FILE__)."/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		//CopyDirFiles(dirname(__FILE__)."/tools", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools", true, true);

		return true;
	}

	function UnInstallFiles()
	{
		//DeleteDirFiles(dirname(__FILE__)."/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		//DeleteDirFiles(dirname(__FILE__)."/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components");
		//DeleteDirFiles(dirname(__FILE__)."/tools", $_SERVER["DOCUMENT_ROOT"]."/bitrix/tools");

		return true;
	}

	function DoInstall()
	{
		$this->InstallFiles();
		$this->InstallDB();
	}

	function DoUninstall()
	{
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}