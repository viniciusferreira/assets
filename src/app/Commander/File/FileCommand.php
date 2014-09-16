<?php namespace Rdehnhardt\Assets\Commander\File;

use Laracasts\Commander\CommanderTrait;
use Rdehnhardt\Assets\Commander\Filesystem\FilesystemCommand;

class FileCommand
{
    use CommanderTrait;

    public $filename;
    public $path;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->path = explode('.', $this->filename);
        $this->path = end($this->path);
        $this->filesystem = $this->execute(FilesystemCommand::class, ['path' => $this->path]);
    }

    public function getFilesystem() {
        return $this->filesystem;
    }
}