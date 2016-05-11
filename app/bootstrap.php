<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Environment initialization
 */
error_reporting(E_ALL);
#ini_set('display_errors', 1);

/* PHP version validation */
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50522) {
    if (PHP_SAPI == 'cli') {
        echo 'Magento supports PHP 5.5.22 or later. ' .
            'Please read http://devdocs.magento.com/guides/v1.0/install-gde/system-requirements.html';
    } else {
        echo <<<HTML
<div style="font:12px/1.35em arial, helvetica, sans-serif;">
    <p>Magento supports PHP 5.5.22 or later. Please read
    <a target="_blank" href="http://devdocs.magento.com/guides/v1.0/install-gde/system-requirements.html">
    Magento System Requirements</a>.
</div>
HTML;
    }
    exit(1);
}

/* Custom umask value may be provided in optional mage_umask file in root */
$umaskFile = BP . '/magento_umask';
$mask = file_exists($umaskFile) ? octdec(file_get_contents($umaskFile)) : 002;
umask($mask);

require_once __DIR__ . '/autoload.php';
require_once BP . '/app/functions.php';

if (!empty($_SERVER['MAGE_PROFILER'])
    && isset($_SERVER['HTTP_ACCEPT'])
    && strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false
) {
    \Magento\Framework\Profiler::applyConfig(
        $_SERVER['MAGE_PROFILER'],
        BP,
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
    );
}

date_default_timezone_set('UTC');
