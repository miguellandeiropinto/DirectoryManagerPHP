<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 08/04/2017
 * Time: 19:24
 */

namespace DirectoryManager;

class DirectoryManager extends AbstractManager
{

    public $templates_files_directory = 'templates';

    public function __construct($ctx = '')
    {

        parent::__construct($ctx);
        $this->file_manager = new FileManager($ctx);

    }

    public function cd($path = '.')
    {
        parent::cd($path);
        $this->file_manager->cd($path);
    }

    public function getFileManager($ctx = null)
    {
        return $this->file_manager;
    }

    public function rename($dir, $name)
    {
        if (!$dir || !$name)
            throw new \InvalidArgumentException('this method has 2 mandatory parameters.');

        try {
            if (rename($this->current_path . '/' . $dir, $this->current_path . '/' . $name))
                return true;
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }

        return false;
    }

    public function copy($src = '.', $dst = '')
    {
        $dir = opendir($src);
        $this->mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);

        return $this;

    }

    public function mkdir($pathToDir = null)
    {

        if (!$pathToDir)
            throw new \InvalidArgumentException('path to dir must be valid!');

        return @mkdir($this->current_path . '/' . $pathToDir, 0777, true);

    }

    public function emptyDir($target)
    {
        if (substr($target, strlen($target) - 1, 1) != '/') {
            $target .= '/';
        }
        $files = glob($target . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->emptyDir($file);
            } else {
                @unlink($file);
            }
        }
        $this->rmdir($target);
    }

    public function rmdir($target = '.', $recursive = false)
    {
        if (!is_dir($target)) {
            throw new InvalidArgumentException("$target must be a directory");
        }

        if ($recursive) {
            return $this->emptyDir($target);
        } else {
            return @rmdir($this->current_path . '/' . $target);
        }

    }


}
