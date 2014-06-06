<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser'] = array(
	'className' => 'GeorgRinger\\ExtbaseStrict\\Xclass\\Typo3DbQueryParser',
);