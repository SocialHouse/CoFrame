<?php
namespace Dompdf;
define("DOMPDF_ENABLE_REMOTE", TRUE);
define('DOMPDF_ENABLE_CSS_FLOAT', TRUE);
define('DOMPDF_ENABLE_JAVASCRIPT', TRUE);
define('isHtml5ParserEnabled', TRUE);
define('DOMPDF_ENABLE_FONTSUBSETTING', TRUE);
define('DOMPDF_ENABLE_PHP', FALSE);
define('DOMPDF_LOG_OUTPUT_FILE', 'temp');
define('DEBUGCSS', TRUE);
define('DOMPDF_PDF_BACKEND', TRUE);
define('DEBUG_LAYOUT', TRUE);
define('DEBUGKEEPTEMP', TRUE);
define('DOMPDF_TEMP_DIR', TRUE );


/**
 * Autoloads Dompdf classes
 *
 * @package Dompdf
 */
class Autoloader
{
    const PREFIX = 'Dompdf';

    /**
     * Register the autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * Autoloader
     *
     * @param string
     */
    public static function autoload($class)
    {
        if ($class === 'Cpdf') {
            require_once __DIR__ . "/../lib/Cpdf.php";
            return;
        }

        $prefixLength = strlen(self::PREFIX);
        if (0 === strncmp(self::PREFIX, $class, $prefixLength)) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $prefixLength));
            $file = realpath(__DIR__ . (empty($file) ? '' : DIRECTORY_SEPARATOR) . $file . '.php');
           if (file_exists($file)) {
                require_once $file;
            }
        }
    }
}