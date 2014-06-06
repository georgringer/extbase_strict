<?php

namespace GeorgRinger\ExtbaseStrict\Xclass;

/**
 * This file is part of the TYPO3 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License, either version 3
 * of the License, or (at your option) any later version.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class Typo3DbQueryParser extends \TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser {

	/**
	 * Builds the language field statement
	 *
	 * @param string $tableName The database table name
	 * @param array &$sql The query parts
	 * @param QuerySettingsInterface $querySettings The TYPO3 CMS specific query settings
	 * @return void
	 */
	protected function addSysLanguageStatement($tableName, array &$sql, $querySettings) {
		if (is_array($GLOBALS['TCA'][$tableName]['ctrl'])) {
			if (!empty($GLOBALS['TCA'][$tableName]['ctrl']['languageField'])) {
				// Select all entries for the current language
				$additionalWhereClause = $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . ' IN (' . (int)$querySettings->getLanguageUid() . ',-1)';
				// If any language is set -> get those entries which are not translated yet
				// They will be removed by t3lib_page::getRecordOverlay if not matching overlay mode
				if (isset($GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'])
					&& $querySettings->getLanguageUid() > 0
				) {

					$mode = $querySettings->getLanguageMode();
					if ($mode === 'strict') {
						$additionalWhereClause = $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=-1' .
						' OR (' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . ' = ' . (int)$querySettings->getLanguageUid() .
							' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] . '=0' .
						') OR (' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=0' .
						' AND ' . $tableName . '.uid IN (SELECT ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] .
						' FROM ' . $tableName .
						' WHERE ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] . '>0' .
						' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=' . (int)$querySettings->getLanguageUid() ;
					} else {
						$additionalWhereClause .= ' OR (' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '=0' .
						' AND ' . $tableName . '.uid NOT IN (SELECT ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] .
						' FROM ' . $tableName .
						' WHERE ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['transOrigPointerField'] . '>0' .
						' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] . '>0';
					}

					// Add delete clause to ensure all entries are loaded
					if (isset($GLOBALS['TCA'][$tableName]['ctrl']['delete'])) {
						$additionalWhereClause .= ' AND ' . $tableName . '.' . $GLOBALS['TCA'][$tableName]['ctrl']['delete'] . '=0';
					}
					$additionalWhereClause .= '))';
				}
				$sql['additionalWhereClause'][] = '(' . $additionalWhereClause . ')';
			}
		}
	}
}