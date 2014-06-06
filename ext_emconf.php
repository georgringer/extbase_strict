<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Improved extbase strict mode support',
	'description' => 'The language mode "strict" is not fully supported by extbase',
	'category' => 'test',
	'author' => 'Georg Ringer',
	'author_email' => 'typo3@ringerge.org',
	'shy' => '',
	'state' => 'alpha',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'version' => '0.0.1',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-6.2.99'
		),
		'conflicts' => array(),
		'suggests' => array(),
	),
);