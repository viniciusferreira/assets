<?php namespace Rdehnhardt\Assets\Http;

use Illuminate\Routing\Controller;

class AssetsController extends Controller
{
    public function file($filename)
    {
        return 'Assets::routing';
    }
}