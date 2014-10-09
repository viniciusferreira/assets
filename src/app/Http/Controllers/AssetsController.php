<?php namespace Rdehnhardt\Assets\Http\Controllers;

use Cache;
use Config;
use Guzzle\Http\Mimetypes;
use Laracasts\Commander\CommanderTrait;
use Rdehnhardt\Assets\Commander\CompileCache\CompileCacheCommand;
use Rdehnhardt\Assets\Commander\File\FileCommand;
use Response;

class AssetsController
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
        if (Config::get('assets::app.debug')) {
            $content = $this->execute(CompileCacheCommand::class, ['hash' => $hash, 'type' => $type]);
        } else {
            if (empty(Cache::has("assets.$type.$hash"))) {
                $content = $this->execute(CompileCacheCommand::class, ['hash' => $hash, 'type' => $type]);
                Cache::forever("assets.$type.$hash", $content);
            } else {
                $content = Cache::get("assets.$type.$hash");
            }
        }

        $Response = Response::make($content, 200);
        $Response->header('Content-Type', Mimetypes::getInstance()->fromFilename("$hash.$type"));
        return $Response;
    }
}