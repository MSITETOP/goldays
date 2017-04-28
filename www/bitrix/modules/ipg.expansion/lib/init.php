<?
namespace IPG\Expansion;

Class Init
{
    function CatalogImport1CComplete() {
        \CModule::IncludeModule('iblock');
        \CModule::IncludeModule('catalog');

        $arIbSKU = array();
        $res = \CIBlock::GetList(
            Array('id' => 'asc'),
            Array(
                'ACTIVE'=>'Y',
                '!XML_ID' => false // заполнено
            )
        );

        // Ищим инфоблоки с SKU
        while($arIblock = $res->Fetch()) {
            $arCatalog = \CCatalog::GetByID($arIblock['ID']);
            if ($arCatalog !== false && is_array($arCatalog) && $arCatalog['PRODUCT_IBLOCK_ID'] > 0) {
                // Это ИБ SKU
                $arIblock['CATALOG'] = $arCatalog;
                $arIbSKU[] = $arIblock;
            }
        }
        //echo "<pre>"; print_r($arIbSKU); echo "</pre>"; die();

        if (count($arIbSKU) > 0) {
            foreach($arIbSKU as $arIblock) {
                $rsProperty = \CIBlockProperty::GetByID($arIblock['CATALOG']['SKU_PROPERTY_ID'], $arIblock['ID']);
                if($arSKUProperty = $rsProperty->Fetch()) {
                    // Проходимся по товарам основного каталога
                    $arSelect = Array("ID", "IBLOCK_ID", "NAME");
                    $arFilter = Array("IBLOCK_ID" => $arIblock['CATALOG']['PRODUCT_IBLOCK_ID']);
                    $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                    while($obElement = $res->GetNextElement()){
                        $arElement = $obElement->GetFields();
                        $arElementProps = $obElement->GetProperties();

                        $arUpdateElementPriopertys = array();

                        // Получаем первый попавшийся SKU
                        $arSelect = Array("ID", "IBLOCK_ID");
                        $arFilter = Array("IBLOCK_ID" => $arIblock['ID'], 'PROPERTY_' . $arSKUProperty['CODE'] => $arElement['ID']);
                        $res2 = \CIBlockElement::GetList(Array(), $arFilter, false, array('nTopCount' => 1), $arSelect);
                        if ($obSKUElement = $res2->GetNextElement()) {
                            //$arFields = $arSKUElement->GetFields();
                            //print_r($arFields);
                            $arProps = $obSKUElement->GetProperties();
                            //print_r($arProps);

                            foreach($arProps['CML2_ATTRIBUTES']['DESCRIPTION'] as $key => $name) {
                                if ($name == 'Размер')
                                    continue;

                                // Составляем список свойств для записи в основной товар
                                $arUpdateElementPriopertys[ $name ] = $arProps['CML2_ATTRIBUTES']['VALUE'][ $key ];
                            }
                        }

                        // Есть характеристики для передачи в основной товар
                        if (count($arUpdateElementPriopertys) > 0) {
                            // Сравнимаем значения свойств, необходимо ли их обновлять?
                            $arUpdateElementPriopertys2 = array();

                            foreach($arUpdateElementPriopertys as $name => $value) {
								if($name=="СКИДКА") {
									if($value>0)
										\CIBlockElement::SetPropertyValueCode($arElement['ID'], "SKID", true);
									else
										\CIBlockElement::SetPropertyValueCode($arElement['ID'], "SKID", false);									
								}
                                // Ищем нужное свойство для сравнения
                                foreach($arElementProps as $arElementProp) {
                                    if ($arElementProp['NAME'] == $name) {
                                        if ($arElementProp['VALUE'] != $value) {
                                            $arUpdateElementPriopertys2[ $name ] = $value;
                                        }
                                        continue(2);
                                    }
                                }

                                // Свойство не найдено в товаре, на добавление
                                $arUpdateElementPriopertys2[ $name ] = $value;
                            }

                            if (count($arUpdateElementPriopertys2) > 0) {
                                // Есть что обновить
                                //echo "UPD:<pre>"; print_r($arUpdateElementPriopertys2); echo "</pre>";

                                // Получим все свойства ИБ
                                $arCatalogPropertys = array();
                                $obCatalogPropertys = \CIBlockProperty::GetList(array('id' => 'asc'), array('IBLOCK_ID' => $arIblock['CATALOG']['PRODUCT_IBLOCK_ID']));
                                while ($arCatalogProperty = $obCatalogPropertys->GetNext()) {
                                    $arCatalogPropertys[ $arCatalogProperty['NAME'] ] = $arCatalogProperty['CODE'];
                                }
								
                                foreach($arUpdateElementPriopertys2 as $name => $value) {
                                    if (!array_key_exists($name, $arCatalogPropertys)) {
                                        // ADD
                                        $CODE = \CUtil::translit($name, 'ru', array(
                                            "max_len" => 50,
                                            "change_case" => 'U', // 'L' - toLower, 'U' - toUpper, false - do not change
                                            "replace_space" => '_',
                                            "replace_other" => '_',
                                            "delete_repeat_replace" => true,
                                        ));
                                        //добавляем '_' в код свойства, если его наименование начинается с цифры
                                        if(preg_match('/^[0-9]/', $CODE))
                                            $CODE = '_'.$CODE;

                                        $arFields = Array(
                                            "NAME" => $name,
                                            "ACTIVE" => "Y",
                                            "SORT" => "500",
                                            "CODE" => $CODE,
                                            "PROPERTY_TYPE" => "S",
                                            "IBLOCK_ID" => $arIblock['CATALOG']['PRODUCT_IBLOCK_ID'],
                                        );

                                        //заполняем созданное свойство
                                        $ibp = new \CIBlockProperty;
                                        if ($PropID = $ibp->Add($arFields))
                                            \CIBlockElement::SetPropertyValueCode($arElement['ID'], $CODE, $value);
                                    } else {
                                        // UPDATE
                                        \CIBlockElement::SetPropertyValueCode($arElement['ID'], $arCatalogPropertys[ $name ], $value);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $arFields
     * OnAfterIBlockElementUpdate event
     * OnAfterIBlockElementAdd event
     */
    function IsSkipIB($IBLOCK_ID) {
        static $arSkipIB = array();

        if (array_key_exists($IBLOCK_ID, $arSkipIB)) {
            if ($arSkipIB[ $IBLOCK_ID ] === true)
                return true;

        } else {
            $arCatalog = \CCatalog::GetByID($IBLOCK_ID);
            if ($arCatalog === false || !is_array($arCatalog) || !isset($arCatalog['PRODUCT_IBLOCK_ID']) || $arCatalog['PRODUCT_IBLOCK_ID']  == 0) {
                // Это НЕ ИБ SKU
                $arSkipIB[ $IBLOCK_ID ] = true;
                return true;

            } else {
                $arSkipIB[ $IBLOCK_ID ] = false;
            }
        }

        return false;
    }

    function ATTRIBUTES2PROP(&$arFields) {
        if ((@$_REQUEST['type']=='catalog')   && (@$_REQUEST['mode']=='import')) {    //выгрузка из 1С?
            $IBLOCK_ID = $arFields['IBLOCK_ID'];
            $ELEMENT_ID = $arFields['ID'];

            if (self::IsSkipIB($IBLOCK_ID))
                return true;

            // получаем массив значений множественного свойства CML2_ATTRIBUTES в которое стандартно выгружаются характеристики ТП из 1С
            $CML2_ATTRIBUTES = \CIBlockElement::GetProperty($IBLOCK_ID, $ELEMENT_ID, array("sort" => "asc"), Array("CODE"=>"CML2_ATTRIBUTES"));

            while ($CML2_ATTRIBUTE = $CML2_ATTRIBUTES->GetNext()) {
                $VALUE = $CML2_ATTRIBUTE['VALUE']; //значение характеристики
                $DESCRIPTION = $CML2_ATTRIBUTE['DESCRIPTION']; //название характеристики

                if (strlen($VALUE) == 0 || strlen($DESCRIPTION) == 0)
                    continue;

                self::PropertyAddUpdate($IBLOCK_ID, $ELEMENT_ID, $VALUE, $DESCRIPTION);
            }
        }
    }

    function PropertyAddUpdate($IBLOCK_ID, $ELEMENT_ID, $VALUE, $DESCRIPTION) {
        //проверяем, есть ли свойство с названием как в описание значения свойства в CML2_ATTRIBUTES
        $arProp = \CIBlockElement::GetProperty($IBLOCK_ID, $ELEMENT_ID, array("sort" => "asc"), Array("NAME"=> $DESCRIPTION))->Fetch();

        //транслителируем символьный код из наименования
        $CODE = \CUtil::translit($DESCRIPTION, 'ru', array(
            "max_len" => 50,
            "change_case" => 'U', // 'L' - toLower, 'U' - toUpper, false - do not change
            "replace_space" => '_',
            "replace_other" => '_',
            "delete_repeat_replace" => true,
        ));

        //добавляем '_' в код свойства, если его наименование начинается с цифры
        if(preg_match('/^[0-9]/', $CODE))
            $CODE = '_'.$CODE;

        $arFields = Array(
            "NAME" => $DESCRIPTION,
            "ACTIVE" => "Y",
            "SORT" => "500",
            "CODE" => $CODE,
            "PROPERTY_TYPE" => "L",
            "IBLOCK_ID" => $IBLOCK_ID,
        );

        if (is_array($arProp) && $arProp['ID'] > 0) {
            if ($arProp['PROPERTY_TYPE'] != 'L') {
                // Convert format
                $ibp = new \CIBlockProperty;
                $ibp->Update($arProp['ID'], $arFields);
            }

            self::SetPropertyListValue($arProp['ID'], $VALUE, $ELEMENT_ID, $CODE, $IBLOCK_ID);

        } else {
            $ibp = new \CIBlockProperty;
            if ($PropID = $ibp->Add($arFields)) {
                self::SetPropertyListValue($PropID, $VALUE, $ELEMENT_ID, $CODE, $IBLOCK_ID);
            }
        }
    }

    function SetPropertyListValue($ID, $Value, $ELEMENT_ID, $CODE, $IBLOCK_ID) {
        // Проверочка и добавление элемента списка
        self::VerifyAndAddPropertyListEnum($ID, $Value);

        // Получаем список значений списка, из него нам нужен ID $VALUE
        $arPropValues = self::GetPropertyListValues($ID);
        foreach($arPropValues as $id => $arValue) {
            if ($arValue['VALUE'] == $Value) {
                //\CIBlockElement::SetPropertyValueCode($ELEMENT_ID, $CODE, $id);
                \CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, $IBLOCK_ID, array($CODE => $id));
                return true;
            }
        }

        return false;
    }

    function VerifyAndAddPropertyListEnum($ID, $Value) {
        // Получаем существующие значения списка и добавляем к нему новое
        $arPropValues = self::GetPropertyListValues($ID);

        // Проверяем есть ли уже такое значение
        foreach($arPropValues as $arValue) {
            if ($arValue['VALUE'] == $Value)
                return false;
        }

        $arPropValues[] = array(
            //'SORT' => 500,
            'VALUE' => $Value,
            //'XML_ID' => '',
            'DEF' => 'N'
        );

        // Обновляем список новыми значениями
        $CIBlockProp = new \CIBlockProperty;
        $CIBlockProp->UpdateEnum($ID, $arPropValues, false);

        return true;
    }

    function GetPropertyListValues($PROP_ID) {
        $ar_all_values = Array();
        $db_enum_list = \CIBlockProperty::GetPropertyEnum($PROP_ID, Array('SORT'=>'ASC'));
        while($ar_enum = $db_enum_list->Fetch()) {
            $ar_all_values[ $ar_enum['ID'] ] = Array(
                'SORT' => $ar_enum['SORT'],
                'VALUE' => $ar_enum['VALUE'],
                'XML_ID' => $ar_enum['ID'],
                'DEF' => $ar_enum['DEF']
            );
        }

        return $ar_all_values;
    }
}