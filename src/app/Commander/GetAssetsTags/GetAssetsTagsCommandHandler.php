<?php namespace Rdehnhardt\Assets\Commander\GetAssetsTags;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\CommandHandler;
use Rdehnhardt\Assets\Commander\Filesystem\FilesystemCommand;

class GetAssetsTagsCommandHandler implements CommandHandler
{
    private $filesystem;

    public function __construct(FilesystemCommand $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function handle($command)
    {
        return $this;
    }

    public function styles()
    {
        dd($this->filesystem);
        return 'styles';
    }

    public function scripts()
    {
        return 'scripts';
    }
}