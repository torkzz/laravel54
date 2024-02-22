<?php
namespace App\Traits;

trait ClamAVTrait
{
    public function isFileClean($filePath)
    {
        // Escape the file path to prevent command injection
        $escapedFilePath = escapeshellarg($filePath);

        // Run clamdscan command
        $output = shell_exec("clamdscan --no-summary {$escapedFilePath}");

        // Check the output for the presence of the string "OK"
        return strpos($output, 'OK') !== false;
    }
}