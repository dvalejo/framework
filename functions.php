<?php

function d($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function setErrorsMessages($method, $errors) {
    $e = [];
    $global = ($method === 'POST') ? $_POST : $_GET;
    foreach ($errors as $field_name => $error) {
        if (empty($global[$field_name])) {
            $e[$field_name] = $error;
        }
    }
    return $e;
}

// Recursively remove banner directory with files
// -----------------------------------------------------------------------------
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

// Remove banner archive file
// -----------------------------------------------------------------------------
function removeBannerArchive($bannerArchive) {
    return unlink($bannerArchive);
}

/**
 * Check if a directory is empty (a directory with just '.svn' or '.git' is empty)
 *
 * @param string $dirname
 * @return bool
 */
function dir_is_empty($dirname)
{
    if (!is_dir($dirname)) return false;
    foreach (scandir($dirname) as $file)
    {
        if (!in_array($file, array('.','..','.svn','.git'))) return false;
    }
    return true;
}

// Clean directories that not in use and uploads table
// -----------------------------------------------------------------------------
function cleanUnusedBanners ($pdo) {
    try {
        $statement = $pdo->query('SELECT project_directory, banner_directory FROM uploads WHERE in_use = 0');
        $uploads_to_remove = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($uploads_to_remove as $item) {
            removeDirectoryWithFiles($item['banner_directory']);
            if (dir_is_empty($item['project_directory'])) {
                rmdir($item['project_directory']);
            }
        }
        $pdo->query('DELETE FROM uploads WHERE in_use = 0');
    }
    catch (PDOException $e) {
        $error['message'] = $e->getMessage();
        $error['file'] = $e->getFile();
        $error['line'] = $e->getLine();
        require LOCAL_ADMIN_VIEWS_DIR . "/error.view.php";
        exit();
    }
}