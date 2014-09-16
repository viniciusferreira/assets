<?php namespace Rdehnhardt\Assets\Commander\Filesystem;

use Symfony\Component\Finder\Finder;

class FilesystemCommand
{
    public $path;
    public $finder;

    public function __construct($path)
    {
        $this->path = base_path("resources/assets/$path");
    }

    public function getFinder($path = null)
    {
        $this->finder = new Finder();
        $this->finder->useBestAdapter()->in($this->path);

        if ($path) {
            $this->finder->in($path);
        }

        return $this->finder;
    }
}