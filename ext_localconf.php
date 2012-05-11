<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_chdeleteorphans_deleteorphans'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'deteled orphans from db',
    'description'      => 'delete orphaned pages and content elements'
);
?>
