<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

class MyStatComponent extends CBitrixComponent
{
	public function onPrepareComponentParams($arParams)
	{
		return $arParams;
	}

	public function executeComponent()
	{

        $this->arResult['AJAX_URL'] = $this->__path;

		$this->includeComponentTemplate();
	}
}

