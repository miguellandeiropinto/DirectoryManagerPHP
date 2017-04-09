<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 08/04/2017
 * Time: 19:47
 */

namespace DirectoryManager;


class FileManager
{

    public $ctx = './';
    public $dirm = null;

    public function __construct($ctx, $dirm)
    {

        $this->ctx = $ctx;
        $this->dirm = $dirm;

    }

    public function mkfile($name = null)
    {

        if (!$name)
            throw new \InvalidArgumentException("file name cannot be null!");

        try {
            $fh = fopen($this->dirm->current_path . '/' . $name, 'w');
            fclose($fh);
            return File::setup($this->dirm->current_path . '/' . $name);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return false;

    }

    public function rmfile($name)
    {

        if (!$name)
            throw new \InvalidArgumentException("file name cannot be null!");

        if (unlink($this->dirm->current_path . '/' . $name))
            return true;

        return false;

    }

    public function rename($file = null, $name = null)
    {

        if (!$file || !$name)
            throw new \InvalidArgumentException('this method has 2 mandatory parameters.');

        try {
            if (rename($this->dirm->current_path . '/' . $file, $this->dirm->current_path . '/' . $name))
                return true;
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }

        return false;
    }

    public function copy($file = null, $dest = null)
    {

        if (!$file || !$dest)
            throw new \InvalidArgumentException('this method has 2 mandatory parameters.');

        try {
            if (copy($this->dirm->current_path . '/' . $file, $this->dirm->current_path . '/' . $dest))
                return true;
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }

        return false;
    }

    public function find($path)
    {
        if (file_exists($this->dirm->current_path . '/' . $path)) {
            return new File($this->dirm->current_path . '/' . $path);
        }
        return false;
    }

}