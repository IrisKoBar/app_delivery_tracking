<?php
/**
* Ukrainian language file
*
*/

$dictionary=array(

'DT_TAB_TRACK' => 'Трек-номер',
'DT_TAB_DESCRIPTION' => 'Опис',
'DT_TAB_WEIGHT' => 'Вага, кг',
'DT_TAB_ADDRESS' => 'Адреса доставки',
'DT_TAB_ADDRESSEE' => 'Отримувач',
'DT_TAB_DEST' => 'Країна доставки',
'DT_TAB_TYPE' => 'Тип відправлення',
'DT_TAB_CARRIER' => 'Поштова служба',
'DT_TAB_LOCATION' => 'Місцезнаходження',
'DT_TAB_IN_WAY' => 'В дорозі (днів)',
'DT_TAB_DATA' => 'Дата',
'DT_TAB_DATA_START' => 'Перша реєстрація в системі',
'DT_TAB_DATA_UPDATE' => 'Остання реєстрація в системі',
'DT_TAB_DATA_ARCH' => 'Дата перенесення в архів',
'DT_TAB_DATA_EV' => 'Дата останньої події',
'DT_TAB_DESC_EV' => 'Опис останньої події',

'DT_TITLE_TRACK' => 'Відомості про відправлення',
'DT_TITLE_EVENT' => 'Етапи доставки',

'DT_BTN_URL' => 'Переглянути на сайті',
'DT_BTN_DESC' => 'Редагувати опис',
'DT_BTN_ARCH' => 'Відправити в архів',
'DT_BTN_DEL' => 'Видалити',
'DT_BTN_VIEW' => 'Переглянути докладний опис',
'DT_BTN_VIEW_ARCH' => 'Переглянути архів',
'DT_BTN_SETTINGS' => 'Налаштування',
'DT_BTN_MAIN' => 'На головну сторінку',
'DT_BTN_CREATE' => 'Створити',
'DT_BTN_UPD' => 'Оновити зараз',
'DT_BTN_OK' => 'Відправити',
'DT_BTN_RESET' => 'Відмінити',
'DT_BTN_RESTORE' => 'Відновити з архіву',

'DT_MSG_ERR_API1' => 'Не заповнено поле з ключем API - додаток не може працювати коректно.',
'DT_MSG_ERR_API2' => 'Будьласка перейдіть в налаштування додатку та заповніть необхідні поля.',
'DT_MSG_TRACK' => 'Введіть трек-номер',
'DT_MSG_DESC' => 'Введіть опис тут...',
'DT_MSG_DEL' => 'Ви впевнені що хочете видалити назавжди?',
'DT_MSG_ARCH' => 'Ви впевнені що хочете перенести в архів?',
'DT_MSG_CREATE' => 'Трек номер додано для відстеження',
'DT_MSG_ALREADY' => 'Цей трек-номер вже є в базі даних',
'DT_MSG_CREATE_ERR' => 'Не вдалося створити відправлення',
'DT_MSG_UPD_TEXT' => 'Оновлено ',
'DT_MSG_UPD_H' => ' год.',
'DT_MSG_UPD_M' => ' хв. назад.',
'DT_MSG_UPD_NOW' => 'Оновлено щойно',
'DT_MSG_UPD_NOT' => 'Ще не оновлювалось.',

'DT_SET_API_TITLE' => 'API ключ',
'DT_SET_API_TOOLTIP' => 'Введіть ваш API сервісу rapidapi.com',
'DT_SET_API_INFO' => "Обов'язковий параметр",
'DT_SET_PRE_TITLE' => 'Префікс для команд',
'DT_SET_PRE_INFO' => 'Ведіть текст-тригер який буде передувати команді/трек-номеру',
'DT_SET_PRE_CMD_TOOLTIP' => 'Не використовуйте символи < > / \ [ ] ( ) ^ . | ? * + { } $',
'DT_SET_CMD_INFO' => 'Команда що буде давати вказівку програмі оновити дані відправлень прям зараз',
'DT_SET_CMD_TITLE' => 'Команда для оновлення',
'DT_SET_EVERYHOUR_TITLE' => 'Частота оновлень кожні',
'DT_SET_EVERYHOUR_TOOLTIP' => 'Введіть кількість годин (0 - 24) - інтервалу автоматичного оновлення інформації про відправлення. Якщо 0 то автооновлення буде вимкнено',
'DT_SET_EVERYHOUR_INFO' => 'годин',
'DT_SET_PERIOD_TITLE' => 'Автоматично оновлювати',
'DT_SET_START_TOOLTIP' => 'Початок періоду автоматичного оновлення даних',
'DT_SET_START_INFO' => 'з',
'DT_SET_FINISH_TOOLTIP' => 'Кінець періоду автоматичного оновлення даних',
'DT_SET_FINISH_INFO' => 'по',
'DT_SET_EXAMPLE_TITLE' => 'Команди для взаємодії',
'DT_SET_EXAMPLE_INFO1' => 'цей запит примусово оновлює інформацію про доставки',
'DT_SET_EXAMPLE_INFO2' => 'цей запит вносить в базу нову посилку',
'DT_SET_EXAMPLE_ERR1' => 'Не задано префікс!',
'DT_SET_EXAMPLE_ERR2' => 'Не задано команду на оновлення!',
'DT_SET_EXAMPLE_TRACK' => '"трек-номер"',
'DT_SET_LANG_TITLE' => 'Налаштування мови',
'DT_SET_LANG_1' => 'Без перекладу',
'DT_SET_LANG_2' => 'Перекладати на англійську',
'DT_SET_LANG_3' => 'Перекладати українською',
'DT_SET_LANG_4' => 'Перекладати на російську',
'DT_SET_LANG_5' => 'Перекладати на французську',
'DT_SET_LANG_6' => 'Перекладати на німецьку',
'DT_SET_LVL_TITLE' => 'Рівень сповіщення',
'DT_SET_LVL_TOOLTIP' => 'Введіть необхідний рівень сповіщень для функції say()',
'DT_SET_ARCH_TITLE' => 'Автоматично архівувати',
'DT_SET_SAY_TITLE' => 'Сповіщати про зміну статусу',
'DT_SET_LOG_TITLE' => 'Увімкнути Log'
);

foreach ($dictionary as $k=>$v) {
 if (!defined('LANG_'.$k)) {
  define('LANG_'.$k, $v);
 }
}

?>