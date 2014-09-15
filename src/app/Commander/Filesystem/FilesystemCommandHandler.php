<?php namespace Assets\Commander\Filesystem;

use Laracasts\Commander\CommandHandler;

class FilesystemCommandHandler implements CommandHandler
{
    protected $filesystem;

    public function handle($command)
    {
        $this->filesystem = $command->getFilesystem();

        return $this;
    }

    public function get($filename)
    {
        $iterator = $this->filesystem->files()->path($filename);
        $File = null;

        foreach ($iterator as $file) {
            $File = $file;
        }

        return $File;
    }
}