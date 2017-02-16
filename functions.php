<?php

// Output for debug
// -----------------------------------------------------------------------------
function d($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

// Output for debug with exit
// -----------------------------------------------------------------------------
function dexit($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    exit();
}

/**
 * Recursively remove banner directory with files
 * @param $directory
 * -----------------------------------------------------------------------------
 */
function removeDirectoryWithFiles($directory) {
    if (is_dir($directory)) {
        $dIterator = new DirectoryIterator($directory);
        foreach ($dIterator as $file) {
            if ($file->isDot()) continue;
            if ($file->isDir()) {
                removeDirectoryWithFiles($directory . _DS_ . $file->getFilename());
            }
            else {
                unlink($file->getPathname());
            }
        }
        $dIterator->rewind();
        rmdir($directory);
    }
}

/**
 * Check if a directory is empty (a directory with just '.svn' or '.git' is empty)
 * -----------------------------------------------------------------------------
 * @param string $dirname
 * @return bool
 */
function directoryIsEmpty($dirname)
{
    if (!is_dir($dirname)) return false;
    foreach (scandir($dirname) as $file)
    {
        if (!in_array($file, array('.','..','.svn','.git'))) return false;
    }
    return true;
}