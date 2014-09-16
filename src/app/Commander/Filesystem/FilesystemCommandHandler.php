<?php namespace Rdehnhardt\Assets\Commander\Filesystem;

use Laracasts\Commander\CommandHandler;

class FilesystemCommandHandler implements CommandHandler
{
    protected $command;
    protected $finder;
    protected $path;

    public function handle($command)
    {
        $this->command = $command;

        return $this;
    }

    public function getFinder($path = null)
    {
        return $this->command->getFinder($path);
    }

    public function getPath($path='')
    {
        if (is_array($path)) {
            foreach ($path as $item) {
                $this->getFinder()->path($item);
            }
        } elseif (isset($path)) {
            $this->getFinder()->path($path);
        }

        return $this->getFinder();
    }

    public function get($filename)
    {
        $iterator = $this->getFinder()->path($filename);
        $File = null;

        foreach ($iterator as $file) {
            $File = $file;
        }

        return $File;
    }

    public function getMap()
    {
        $Map = $this->get('map.php');

        return require $Map->getRealpath();
    }

    public function getFiles($path='')
    {
        $iterator = $this->getFinder()->files()->path($path);
        $output = null;

        if ($iterator->count()) {
            foreach ($iterator as $file) {
                $output[] = $file;
            }
        }

        return $output;
    }
}