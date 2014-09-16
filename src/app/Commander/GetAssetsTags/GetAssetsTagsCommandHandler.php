<?php namespace Rdehnhardt\Assets\Commander\GetAssetsTags;

use App;
use Cache;
use Config;
use Illuminate\Html\HtmlBuilder;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\CommandHandler;
use Rdehnhardt\Assets\Commander\Filesystem\FilesystemCommand;

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
        if (App::environment('local')) {
            if (Config::get('assets::app.explode')) {
                $output = $this->buildExplodedTag($type);
            } else {
                $output = $this->buildProductionTag($type);
            }
        } else {
            $output = $this->buildProductionTag($type);
        }


        if (App::environment('local')) {

        } else {
            $output = $this->buildProductionTag($type);
        }

        return $output;
    }

    protected function buildProductionTag($type)
    {
        if (!Cache::has("assets.hash")) {
            Cache::forever("assets.hash", md5(time()));
        }

        $route = Config::get('assets::app.route') . "/" . Config::get('assets::app.route') . "-" . Cache::get('assets.hash') . "." . $type;
        $output = '';

        switch ($type) {
            case 'css':
                $output .= $this->htmlBuilder->style($route);
                break;

            case 'js':
                $output .= $this->htmlBuilder->script($route);
                break;
        }

        return $output;
    }

    private function buildExplodedTag($type)
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
            $filename = str_replace($file->getExtension() . '/', Config::get('assets::app.route') . '/', $file->getRelativePathname());

            switch ($file->getExtension()) {
                case 'css':
                    $output .= $this->htmlBuilder->style($filename);
                    break;

                case 'js':
                    $output .= $this->htmlBuilder->script($filename);
                    break;
            }
        }
        return strtolower($output);
    }

}