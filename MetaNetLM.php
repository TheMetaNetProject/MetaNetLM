<?php
# Alert the user that this is not a valid access point to MediaWiki if
# they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
    echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MetaNetLM/MetaNetLM.php" );
EOT;
    exit( 1 );
}
 
$wgExtensionCredits[ 'specialpage' ][] = array(
        'path' => __FILE__,
        'name' => 'MetaNetLM',
        'author' => 'Jisup Hong',
        'url' => 'https://metaphor.icsi.berkeley.edu/metaphor',
        'descriptionmsg' => 'metanetlm-desc',
        'version' => '0.0.1',
);
$mnIP = dirname( __FILE__ );
$wgExtensionMessagesFiles[ 'MetaNetLM' ] = $mnIP . '/MetaNetLM.i18n.php'; # Location of a messages file (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles[ 'MetaNetLMAlias' ] = $mnIP . '/MetaNetLM.alias.php'; # Location of an aliases file (Tell MediaWiki to load this file)

$wgSpecialPages[ 'MetaNetLM' ] = 'SpecialMetaNetLM'; # Tell MediaWiki about the new special page and its class name
$wgSpecialPageGroups[ 'MetaNetLM' ] = 'other';

$wgAutoloadClasses[ 'SpecialMetaNetLM' ] = $mnIP . '/SpecialMetaNetLM.php'; # Location of the SpecialMyExtension class (Tell MediaWiki to load this file)
