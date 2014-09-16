<?php namespace Rdehnhardt\Assets\Commander\GetAssetsTags;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\CommanderTrait;
use Rdehnhardt\Assets\Commander\Filesystem\FilesystemCommand;
use Illuminate\Html\HtmlBuilder;

class GetAssetsTagsCommandHandler implements CommandHandler
{
    use CommanderTrait;

    protected $filesystem;
    protected $htmlBuilder;

    public function __construct(HtmlBuilder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
    }

    public function handle($command)
    {
        $this->filesystem = $this->execute(FilesystemCommand::class, ['path' => '']);

        return $this;
    }

    public function styles()
    {
        return $this->getOutput('css');
    }

    public function scripts()
    {
        return $this->getOutput('js');
    }

    protected function getOutput($type)
    {
        $Mapping = $this->filesystem->get("{$type}/map.php");
        $output = null;

        if (is_object($Mapping)) {
            $expressions = require $Mapping->getRealpath();

            foreach ($expressions as $expression) {
                $output .= $this->buildTagsFromPath($expression);
            }
        } else {
            $output .= $this->buildTagsFromPath($type);
        }

        return $output;
    }

    protected function buildTagsFromPath($expression)
    {
        $iterator = $this->filesystem->getFiles($expression);
        $output = null;

        foreach ($iterator as $file) {
            $filename = str_replace($file->getExtension().'/', 'assets/', $file->getRelativePathname());

            switch ($file->getExtension()) {
                case 'css':
                    $output .= $this->htmlBuilder->style($filename);
                    break;

                case 'js':
                    $output .= $this->htmlBuilder->script($filename);
                    break;
            }
        }
        return $output;
    }


}