<?php

namespace tuefekci\helpers;

/**
* Files Class
*
* This class offers function and helpers for working with files.
*
* @author Giacomo Tüfekci
* @package tuefekci\helpers
*/

class Files
{

    /**
     * File Exists
     *
     * This function is a replacement for file_exists but more performant.
     * https://tutorialspage.com/benchmarking-on-the-glob-and-readdir-php-functions/
     *
     * @param string $path path to file to check.
     * @return bool true/false
     */
    public static function exists(string $path)
    {
        if (is_file($path) or is_dir($path)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Scan Recursive
     *
     * This function is scans a folder recursively for its and its childrens contents but more performant than glob.
     * https://tutorialspage.com/benchmarking-on-the-glob-and-readdir-php-functions/
     *
     * @param string $dir path to folder to scan.
     * @return array contains all paths as strings.
     */
    public static function rscandir(string $dir)
    {
        if (is_dir($dir)) {
            $return = array();
            $paths = scandir($dir);
    
            foreach ($paths as $key => $path) {
                if ($path != "." && $path != "..") {
                    if (is_dir($dir.DIRECTORY_SEPARATOR.$path) && !is_link($dir.DIRECTORY_SEPARATOR.$path)) {
                        $return = array_merge($return, self::rscandir($dir.DIRECTORY_SEPARATOR.$path));
                    } else {
                        $return[] = $path;
                    }
                }
            }
    
            return $return;
        } else {
            throw new \Exception('path '.$dir.' is not a directory.');
        }
    }
    
    /**
     * Sync Folders
     *
     * This function syncronises src to dst and allows the option to empty src first.
     *
     * **Attention: This also overwrites contents regardles if changed or not etc.**
     *
     * @param string $src source
     * @param string $dst destination
     * @param bool $clearFolderFirst If to clear the dst folder first.
     * @return void
     */
    public static function sync($src, $dst, $clearFolderFirst = false)
    {
        if ($clearFolderFirst) {
            self::rrmdir($dst);
        }
    
        self::rcopy($src, $dst);
    }
    
    /**
     * Remove Recursive
     *
     * This function is removes a folder recursively including content.
     *
     * @param string $dir
     * @param bool $removeDir If to also remove the dir folder.
     * @return void
     */
    public static function rrmdir($dir, $removeDir = false)
    {
        if (is_dir($dir)) {
            $paths = scandir($dir);
            foreach ($paths as $path) {
                if ($path != "." && $path != "..") {
                    if (is_dir($dir.DIRECTORY_SEPARATOR.$path) && !is_link($dir.DIRECTORY_SEPARATOR.$path)) {
                        self::rrmdir($dir.DIRECTORY_SEPARATOR.$path, true);
                    } else {
                        unlink($dir.DIRECTORY_SEPARATOR.$path);
                    }
                }
            }
    
            if ($removeDir) {
                rmdir($dir);
            }
        } else {
            throw new \Exception('path '.$dir.' is not a directory.');
        }
    }
    
    /**
     * Copy Recursive
     *
     * copies files and non-empty directories
     *
     * @param string $src source
     * @param string $dst destination
     * @return void
     */
    public static function rcopy($src, $dst)
    {
        if (self::exists($dst)) {
            self::rrmdir($dst);
        }
        if (is_dir($src)) {
            if (!self::exists($dst)) {
                mkdir($dst);
            }
            $paths = scandir($src);
            foreach ($paths as $path) {
                if ($path != "." && $path != "..") {
                    self::rcopy($src.DIRECTORY_SEPARATOR.$path, $dst.DIRECTORY_SEPARATOR.$path);
                }
            }
        } elseif (self::exists($src)) {
            copy($src, $dst);
        }
    }
}
