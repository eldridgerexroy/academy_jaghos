<?php

/**
 * Recursively scan a directory for files with a specific extension.
 *
 * @param string $dir The directory to scan.
 * @param string $ext The file extension to look for.
 * @return array The list of files with the specified extension.
 */
function scanDirForFilesWithExtension(string $dir, string $ext): array {
    $files = [];
    $items = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($items as $item) {
        if ($item->isFile() && $item->getExtension() === $ext) {
            $files[] = $item->getPathname();
        }
    }
    return $files;
}

/**
 * Check a file for the presence of closures.
 *
 * @param string $file The file to check.
 * @return bool True if the file contains a closure, false otherwise.
 */
function fileContainsClosure(string $file): bool {
    $contents = file_get_contents($file);
    return strpos($contents, 'function') !== false;
}

// Scan the config directory for PHP files
$configDir = __DIR__ . '/config';
$phpFiles = scanDirForFilesWithExtension($configDir, 'php');

// Check each PHP file for closures
$filesWithClosures = [];
foreach ($phpFiles as $file) {
    if (fileContainsClosure($file)) {
        $filesWithClosures[] = $file;
    }
}

// Output the results
if (empty($filesWithClosures)) {
    echo "No closures found in configuration files.\n";
} else {
    echo "The following configuration files contain closures:\n";
    foreach ($filesWithClosures as $file) {
        echo $file . "\n";
    }
}
