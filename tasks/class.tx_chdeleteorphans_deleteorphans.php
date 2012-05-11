<?php

/***************************************************************
* Copyright notice
*
* (c) 2012 Christian Hansen (quid@gmx.de)
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * delete orphans - pages and content elements
 * especially written for pages to avoid broken rootline incidents
 * and keep database clean
 *
 * @return boolean
 */
class tx_chdeleteorphans_deleteorphans extends tx_scheduler_Task {

	public function execute() {
		$errors = array();

		// delete pages
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
			'pages AS pages_mother JOIN pages AS pages_child ON pages_mother.uid = pages_child.pid',
			'pages_mother.deleted = 1 AND pages_child.deleted = 0',
			array('pages_child.deleted' => 1)
			) or ($errors[] = $GLOBALS['TYPO3_DB']->sql_error());

		// delete content elements
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
			'pages JOIN tt_content ON pages.uid = tt_content.pid',
			'pages.deleted = 1 AND tt_content.deleted = 0',
			array('tt_content.deleted' => 1)
			) or ($errors[] = $GLOBALS['TYPO3_DB']->sql_error());

		if (empty($errors)) {
			return true;
		} else {
			debug($errors);
			return false;
		}
	}

}
?>
