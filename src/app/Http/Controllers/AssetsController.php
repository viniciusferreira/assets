<?php namespace Rdehnhardt\Assets\Http\Controllers;

use Config;
use Guzzle\Http\Mimetypes;
use Illuminate\Routing\Controller;
use Laracasts\Commander\CommanderTrait;
use Rdehnhardt\Assets\Commander\CompileCache\CompileCacheCommand;
use Rdehnhardt\Assets\Commander\File\FileCommand;
use Response;
use Cache;

class AssetsController extends Controller
{
    use CommanderTrait;

    public function file($filename)
    {
        $File = $this->execute(FileCommand::class, ['filename' => $filename]);
        if (Config::get('assets::app.debug')) {
            $content = $File->getContent();
        } else {
            $content = $File->getCached();
        }

        $Response = Response::make($content, 200);
        $Response->header('Content-Type', Mimetypes::getInstance()->fromFilename($filename));

        return $Response;
    }

    public function application($hash, $type)
    {
        if (empty(Cache::has("assets.$type.$hash"))) {
            $this->execute(CompileCacheCommand::class, ['hash' => $hash,  'type' => $type]);
        }

        $Response = Response::make(Cache::get("assets.$type.$hash"), 200);
        $Response->header('Content-Type', Mimetypes::getInstance()->fromFilename("$hash.$type"));

        return $Response;

    }
}