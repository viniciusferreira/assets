<?php namespace Assets\Commander\File;

use Illuminate\Support\Facades\Config;
use Laracasts\Commander\CommandHandler;
use Assets\Commander\Minify\MinifyCommand;
use Laracasts\Commander\CommanderTrait;

class FileCommandHandler implements CommandHandler
{
    use CommanderTrait;

    protected $filesystem;
    protected $filename;
    protected $hash;

    public function handle($command)
    {
        $this->filesystem = $command->filesystem;
        $this->filename = $command->filename;

        return $this;
    }

    public function getFile() {
        return $this->filesystem->get($this->filename);
    }

    public function getCached()
    {
        return Cache::get($this->filename);
    }

    public function getContent()
    {
        if (!Config::get('app.debug')) {
            return $this->getFileContent();
        } else {
            return $this->getFileContentMinified();
        }
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