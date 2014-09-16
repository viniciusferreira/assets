<?php namespace Rdehnhardt\Assets\Http\Controllers;

use Illuminate\Routing\Controller;
use Laracasts\Commander\CommanderTrait;
use Rdehnhardt\Assets\Commander\File\FileCommand;
use Symfony\Component\Finder\SplFileInfo;
use Config;
use Guzzle\Http\Mimetypes;
use Response;

class AssetsController extends Controller
{
    use CommanderTrait;

    public function file($filename)
    {
        $File = $this->execute(FileCommand::class, ['filename' => $filename]);
        if (Config::get('app.debug')) {
            $content = $File->getContent();
        } else {
            $content = $File->getCached();
        }

        $mimeType = Mimetypes::getInstance()->fromFilename($filename);
        $Response = Response::make($content, 200);
        $Response->header('Content-Type', $mimeType);

        return $Response;
    }
}