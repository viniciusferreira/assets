<?php namespace Rdehnhardt\Assets\Commander\CompileCache;

class CompileCacheCommand
{
    public $hash;
    public $type;

    public function __construct($hash, $type)
    {
        $this->hash = $hash;
        $this->type = $type;
    }
} 