<?php
/**
 * Created by PhpStorm.
 * User: Utlizador
 * Date: 09/04/2017
 * Time: 02:38
 */

declare(strict_types=1);

namespace DirectoryManager;


class File
{

    protected $abspath = '';
    protected $handler = null;
    protected $extension = '';
    protected $size;
    protected $content;

    public function __construct($path)
    {
        $this->abspath = $path;
        $_ = explode('.', $this->abspath);
        $this->extension = end($_);
        $this->content = $this->getContents();
    }

    public function getContents()
    {
        return file_get_contents($this->abspath);
    }

    public function save()
    {
        file_put_contents($this->abspath, $this->content);
        return $this;
    }

    public function write($content = '')
    {
        $this->content .= $content;
        return $this;
    }

    public function emptyFile()
    {
        file_put_contents($this->abspath, '');
        return new self($this->abspath);
    }

}