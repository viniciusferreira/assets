<?php namespace Rdehnhardt\Assets\Commander\GetAssetsTags;

use Cache;
use App;

class GetAssetsTagsCommand
{
    public $tagsScripts;
    public $tagsStyles;

    public function __construct()
    {
        if (App::environment('production')) {
            $this->tagsScripts = Cache::get('assets.tags.scripts');
            $this->tagsStyles = Cache::get('assets.tags.styles');
        }
    }
}