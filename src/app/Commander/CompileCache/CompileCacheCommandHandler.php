<?php namespace Rdehnhardt\Assets\Commander\CompileCache;

use Cache;
use Config;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\CommandHandler;
use Rdehnhardt\Assets\Commander\File\FileCommand;
use Rdehnhardt\Assets\Commander\Filesystem\FilesystemCommand;

class CompileCacheCommandHandler implements CommandHandler
{
    use CommanderTrait;

    protected $filesystem;
    protected $compile;

    public function handle($compile)
    {
        $this->filesystem = $this->execute(FilesystemCommand::class, ['path' => $compile->type]);

        return $this->getOutput($compile->type);
    }

    protected function getOutput($type)
    {
        $Mapping = $this->filesystem->get("{$type}/map.php");
        $output = null;

        if (is_object($Mapping)) {
            $expressions = require $Mapping->getRealpath();

            foreach ($expressions as $expression) {
                $output .= $this->getContent($expression);
            }
        } else {
            $output .= $this->getContent($type);
        }

        return $output;
    }

    protected function getContent($expression)
    {
        $iterator = $this->filesystem->getFiles($expression);
        $output = null;

        if (is_array($iterator) && count($iterator)) {
            foreach ($iterator as $file) {
                $filename = str_replace($file->getExtension() . '/', Config::get('assets::app.name') . '/', $file->getRelativePathname());
                $File = $this->execute(FileCommand::class, ['filename' => $filename]);

                $output .= $File->getContent();
            }
        }

        return $output;
    }
}