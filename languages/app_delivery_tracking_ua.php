<?php
/**
* Ukrainian language file
*
*/

$dictionary=array(

'DT_NAME_TRACK' => 'Трек номер',
'DT_NAME_DESCRIPTION' => 'Опис',
'DT_NAME_WEIGHT' => 'Вага, кг',
'DT_NAME_ADDRESS' => 'Адреса',
'DT_NAME_DEST' => 'Цільова країна',
'DT_NAME_URL' => 'Переглянути на сайті',
'DT_NAME_START_DATA' => 'Перша реєстрація в системі',
'DT_NAME_LAST_DATA' => 'Час останньої події',
'DT_NAME_LAST_DESC' => 'Опис останньої події',
'DT_NAME_UPDATE_DATA' => 'Останнє оновлення в системі',
'DT_NAME_CARRIERS' => 'Поштова служба',
'DT_NAME_LOCATION' => 'Розташування',
'DT_NAME_IN_WAY' => 'В дорозі',
'DT_NAME_DATA' => 'Дата події',
'DT_NAME_EVENT' => 'Опис події',
'DT_TITLE_TRACK' => 'Відомості про відправлення',
'DT_TITLE_EVENT' => 'Етапи доставки',
'DT_BTN_DESC' => 'Оновити опис',
'DT_BTN_ARCH' => 'Відправити в архів',
'DT_BTN_DEL' => 'Видалити',
'DT_PAGE_MAIN' => 'На головну сторінку',
'DT_PAGE_PREV' => 'Повернутися'

);

foreach ($dictionary as $k=>$v) {
 if (!defined('LANG_'.$k)) {
  define('LANG_'.$k, $v);
 }
}

?>