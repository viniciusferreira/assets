<?php namespace Assets\Commander\File;

use Assets\Commander\Minify\MinifyCommand;
use Cache;
use Event;
use Illuminate\Support\Facades\Config;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\CommandHandler;

class FileCommandHandler implements CommandHandler
{
    use CommanderTrait;

    protected $filesystem;
    public $filename;

    public function handle($command)
    {
        $this->filesystem = $command->filesystem;
        $this->filename = $command->filename;

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