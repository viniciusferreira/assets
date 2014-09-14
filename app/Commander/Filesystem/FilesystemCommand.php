<?php namespace Assets\Commander\Filesystem;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\Adapter\GnuFindAdapter;

class FilesystemCommand
{
    public $path;
    protected $adapter = 'gnu';

    public function __construct($path)
    {
        $path = base_path("resources/assets/$path");

        $this->finder = new Finder();
        $this->finder->in($path);
    }

    public function getFilesystem()
    {
        return $this->finder;
    }
}