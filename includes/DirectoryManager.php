<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 08/04/2017
 * Time: 19:24
 */

namespace DirectoryManager;

class DirectoryManager
{

    public $ctx = '/';
    public $current_path = __DIR__;
    public $current_path_array = [];
    public $file_manager = null;
    public $templates_files_directory = 'templates';
    private $initial_path = __DIR__;
    private $initial_path_array = [];

    public function __construct($ctx = '/')
    {

        $this->initial_path = str_replace("\\", '/', __DIR__);
        $this->initial_path_array = explode('/', $this->initial_path);
        $this->current_path = implode('/', $this->initial_path_array);
        $this->current_path_array = $this->initial_path_array;

        $this->setContext($ctx);
        $this->file_manager = $this->getFileManager($this->ctx);

    }

    public function setContext($ctx = null)
    {

        if (!$ctx)
            throw new \InvalidArgumentException('Context cannot be null!');

        return $this->parseContext($ctx);
    }

    public function parseContext($ctx)
    {

        $_ctx = str_replace("\\", "/", $ctx);
        $_ctx_array = explode('/', $_ctx);

        foreach ($_ctx_array as $t) {

            if ($t == '.') {
                continue;
            }

            if ($t == '..') {
                $this->goUp();
            } else {
                $this->goDown($t);
            }

        }
        $this->current_path = $this->contextToPath();
        return $this;

    }

    public function goUp()
    {

        array_pop($this->current_path_array);
        return true;

    }

    public function goDown($dir = null)
    {

        if (!$dir || !is_dir($this->current_path . '/' . $dir)) return false;
        $this->current_path_array[] = $dir;
        return true;

    }

    public function contextToPath()
    {

        return implode('/', $this->current_path_array);

    }

    public function getFileManager($ctx = null)
    {

        if (!$ctx) {
            return new FileManager($this->ctx, $this);
        }

        return new FileManager($ctx, $this);

    }

    public function setup($ctx = './')
    {
        return new self($ctx);
    }

    public function getContext()
    {

        return $this->ctx;

    }

    public function cd($path = ".")
    {
        $this->setContext($path);
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

        return mkdir($this->current_path . '/' . $pathToDir, 0777, true);

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
                unlink($file);
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
            return rmdir($this->current_path . '/' . $target);
        }

    }


}
