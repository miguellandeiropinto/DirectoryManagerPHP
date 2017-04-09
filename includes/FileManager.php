<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 08/04/2017
 * Time: 19:47
 */

declare(strict_types=1);

namespace DirectoryManager;


class FileManager extends AbstractManager
{

    public $ctx = '';

    public function __construct($ctx)
    {
        parent::__construct($ctx);
    }

    public function mkfile($name = null)
    {

        if (!$name)
            throw new \InvalidArgumentException("file name cannot be null!");

        try {
            $fh = @fopen($this->current_path . '/' . $name, 'w');
            fclose($fh);
            return new File($this->current_path . '/' . $name);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return false;

    }

    public function rmfile($name)
    {

        if (!$name)
            throw new \InvalidArgumentException("file name cannot be null!");

        if (@unlink($this->current_path . '/' . $name))
            return true;

        return false;

    }

    public function rename($file = null, $name = null)
    {

        if (!$file || !$name)
            throw new \InvalidArgumentException('this method has 2 mandatory parameters.');

        try {
            if (@rename($this->current_path . '/' . $file, $this->current_path . '/' . $name))
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
            if (@copy($this->current_path . '/' . $file, $this->current_path . '/' . $dest))
                return true;
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            die();
        }

        return false;
    }

    public function find($path)
    {
        if (file_exists($this->current_path . '/' . $path)) {
            return new File($this->current_path . '/' . $path);
        }
        return false;
    }

}