<?php namespace Rdehnhardt\Assets\Commander\File;

use Cache;
use Event;
use Illuminate\Support\Facades\Config;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\CommandHandler;
use Rdehnhardt\Assets\Commander\Minify\MinifyCommand;

class FileCommandHandler implements CommandHandler
{
    use CommanderTrait;

    public $filesystem;
    public $filename;

    public function handle($File)
    {
        $this->filesystem = $File->getFilesystem();
        $this->filename = $File->filename;

        Event::fire('check.file.cache', array($this));

        return $this;
    }

    public function getCached()
    {
        return Cache::get($this->filename);
    }

    public function getContent()
    {
        if (Config::get('app.debug')) {
            return $this->getFileContent();
        } else {
            return $this->getFileContentMinified();
        }
    }

    public function getFile()
    {
        return $this->filesystem->get($this->filename);
    }

    public function getSize()
    {
        return $this->getFile()->getSize();
    }

    private function getFileContent()
    {
        return $this->getFile()->getContents();
    }

    private function getFileContentMinified()
    {
        return $this->execute(MinifyCommand::class, [
            'content' => $this->getFile()->getContents(),
            'type' => $this->getFile()->getExtension()
        ]);
    }
}