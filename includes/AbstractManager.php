<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 09/04/2017
 * Time: 04:48
 */

declare(strict_types=1);

namespace DirectoryManager;


class AbstractManager
{
    public $ctx = '/';
    public $current_path = __DIR__;
    public $current_path_array = [];
    public $file_manager = null;
    public $templates_files_directory = 'templates';
    private $initial_path = __DIR__;
    private $initial_path_array = [];

    public function __construct($ctx = '')
    {
        $this->initial_path = str_replace("\\", '/', __DIR__);
        $this->initial_path_array = explode('/', $this->initial_path);
        $this->current_path = implode('/', $this->initial_path_array);
        $this->current_path_array = $this->initial_path_array;
        $this->ctx = $ctx;
        $this->setContext($ctx);
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
                $this->current_path = $this->contextToPath();
            } else {
                $this->goDown($t);
                $this->current_path = $this->contextToPath();
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

    public function contextToPath()
    {

        return implode('/', $this->current_path_array);

    }

    public function goDown($dir = null)
    {
        if (!$dir || !is_dir($this->current_path . '/' . $dir)) return false;
        $this->current_path_array[] = $dir;
        return true;

    }

    public function getContext()
    {

        return $this->ctx;

    }

    public function cd($path = ".")
    {
        $this->ctx = $path;
        $this->setContext($path);
    }

    public function setup($ctx)
    {
        return new self($ctx);
    }
}