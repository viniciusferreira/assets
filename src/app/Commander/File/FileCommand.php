<?php namespace Assets\Commander\File;

use Assets\Commander\Filesystem\FilesystemCommand;
use Laracasts\Commander\CommanderTrait;
use Illuminate\Filesystem\Filesystem;

class FileCommand
{
    use CommanderTrait;

    public $filename;

    public function __construct($filename)
    {
        $Filesystem = new Filesystem();
        $this->extension = $Filesystem->extension($filename);
        $this->filename = $filename;

        $this->filesystem = $this->execute(FilesystemCommand::class, ['path' => $this->extension]);
    }
}