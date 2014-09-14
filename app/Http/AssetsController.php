<?php namespace Assets\Http;

use Illuminate\Routing\Controller;
use Laracasts\Commander\CommanderTrait;
use Assets\Commander\File\FileCommand;
use Symfony\Component\Finder\SplFileInfo;
use Config;

class AssetsController extends Controller
{
    use CommanderTrait;

    public function file($filename)
    {
        $File = $this->execute(FileCommand::class, ['filename' => $filename]);

        if (Config::get('app.debug')) {
            return $File->getContent();
        } else {
            return $File->getCached();
        }
    }
}