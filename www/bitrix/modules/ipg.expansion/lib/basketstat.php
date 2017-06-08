<?php
namespace IPG\Expansion;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class BasketstatTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> USER_ID int mandatory
 * <li> BASKET_ID int mandatory
 * <li> DATETIME datetime mandatory
 * <li> PRODUCT string mandatory
 * </ul>
 *
 * @package Bitrix\Basketstat
 **/

class BasketstatTable extends Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }

    public static function getTableName()
    {
        return 'ipg_basketstat';
    }

    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('BASKETSTAT_ENTITY_ID_FIELD'),
            ),
            'USER_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                'title' => Loc::getMessage('BASKETSTAT_ENTITY_USER_ID_FIELD'),
            ),
            'DATETIME' => array(
                'data_type' => 'datetime',
                'required' => true,
                'title' => Loc::getMessage('BASKETSTAT_ENTITY_DATETIME_FIELD'),
            ),
            'PRODUCT' => array(
                'data_type' => 'text',
                'required' => true,
                'title' => Loc::getMessage('BASKETSTAT_ENTITY_PRODUCT_FIELD'),
            ),
        );
    }
}
