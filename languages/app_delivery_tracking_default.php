<?php
/**
* Default language file
*
*/

$dictionary=array(

'DT_TAB_TRACK' => 'Track',
'DT_TAB_DESCRIPTION' => 'Description',
'DT_TAB_WEIGHT' => 'Weight, kg',
'DT_TAB_ADDRESS' => 'Destination address',
'DT_TAB_ADDRESSEE' => 'Recipient',
'DT_TAB_DEST' => 'Destination country',
'DT_TAB_TYPE' => 'Type of delivery',
'DT_TAB_CARRIER' => 'Carrier',
'DT_TAB_LOCATION' => 'Location',
'DT_TAB_IN_WAY' => 'In way (days)',
'DT_TAB_DATA' => 'Date',
'DT_TAB_DATA_START' => 'First registration in the system',
'DT_TAB_DATA_UPDATE' => 'Latest registration in the system',
'DT_TAB_DATA_ARCH' => 'Date of archiving',
'DT_TAB_DATA_EV' => 'Date of latest event',
'DT_TAB_DESC_EV' => 'Description of latest event',

'DT_TITLE_TRACK' => 'Delivery detailed data',
'DT_TITLE_EVENT' => 'Phases of delivery',

'DT_BTN_URL' => 'Review on website',
'DT_BTN_DESC' => 'Edit description',
'DT_BTN_ARCH' => 'Archiving',
'DT_BTN_DEL' => 'Remove',
'DT_BTN_VIEW' => 'Review detailed description',
'DT_BTN_VIEW_ARCH' => 'Review archive',
'DT_BTN_SETTINGS' => 'Settings',
'DT_BTN_MAIN' => 'Main page',
'DT_BTN_CREATE' => 'Create',
'DT_BTN_UPD' => 'Update now',
'DT_BTN_OK' => 'Send',
'DT_BTN_RESET' => 'Cancel',
'DT_BTN_RESTORE' => 'Restore',

'DT_MSG_ERR_API1' => 'Input field for API key is not filled. The application can`t work correctly',
'DT_MSG_ERR_API2' => 'Please go to the application settings to fill required fields',
'DT_MSG_TRACK' => 'Enter track number',
'DT_MSG_DESC' => 'Enter description here...',
'DT_MSG_DEL' => 'Are you sure you want to delete permanently?',
'DT_MSG_ARCH' => 'Are you sure you want to archive?',
'DT_MSG_CREATE' => 'Track number is added',
'DT_MSG_ALREADY' => 'This track number is already in the database.',
'DT_MSG_CREATE_ERR' => 'Failed to create delivery',
'DT_MSG_UPD_TEXT' => 'Updated',
'DT_MSG_UPD_H' => ' hour',
'DT_MSG_UPD_M' => ' minutes ago',
'DT_MSG_UPD_NOW' => 'Has just updated',
'DT_MSG_UPD_NOT' => 'Hasn`t updated',

'DT_SET_API_TITLE' => 'API key',
'DT_SET_API_TOOLTIP' => 'Enter your API key for rapidapi.com',
'DT_SET_API_INFO' => "Required parameter",
'DT_SET_PRE_TITLE' => 'Command prefix',
'DT_SET_PRE_INFO' => 'Enter text-trigger that goes before command/track number',
'DT_SET_PRE_CMD_TOOLTIP' => 'Do not use following symbols: < > / \ [ ] ( ) ^ . | ? * + { } $',
'DT_SET_CMD_INFO' => 'Command that will give instructions to program to update sending data now',
'DT_SET_CMD_TITLE' => 'Command to update',
'DT_SET_EVERYHOUR_TITLE' => 'Update frequency every',
'DT_SET_EVERYHOUR_TOOLTIP' => 'Enter number of hours (0 - 24) - for intervals of automatic update. If 0 then auto update will be turned off',
'DT_SET_EVERYHOUR_INFO' => 'hours',
'DT_SET_PERIOD_TITLE' => 'Auto update',
'DT_SET_START_TOOLTIP' => 'Start of auto update period',
'DT_SET_START_INFO' => 'from',
'DT_SET_FINISH_TOOLTIP' => 'End of auto update period',
'DT_SET_FINISH_INFO' => 'to',
'DT_SET_EXAMPLE_TITLE' => 'Commands for interactions',
'DT_SET_EXAMPLE_INFO1' => 'this request updates delivery data by force',
'DT_SET_EXAMPLE_INFO2' => 'this request enters a new delivery into the database',
'DT_SET_EXAMPLE_ERR1' => 'Prefix is not defined!',
'DT_SET_EXAMPLE_ERR2' => 'Update command is not defined!',
'DT_SET_EXAMPLE_TRACK' => '"track-number"',
'DT_SET_LANG_TITLE' => 'Language settings',
'DT_SET_LANG_1' => 'Without translation',
'DT_SET_LANG_2' => 'Translate to English',
'DT_SET_LANG_3' => 'Translate to Ukrainian',
'DT_SET_LANG_4' => 'Translate to Russian',
'DT_SET_LANG_5' => 'Translate to French',
'DT_SET_LANG_6' => 'Translate to German',
'DT_SET_LVL_TITLE' => 'Level of notification',
'DT_SET_LVL_TOOLTIP' => 'Enter necessary level of notification for say() function',
'DT_SET_ARCH_TITLE' => 'Auto archiving',
'DT_SET_SAY_TITLE' => 'Change status notification',
'DT_SET_LOG_TITLE' => 'Log On'
);

foreach ($dictionary as $k=>$v) {
 if (!defined('LANG_'.$k)) {
  define('LANG_'.$k, $v);
 }
}

?>