<?php namespace Assets\Commander\Minify;

use JSMin;
use CssMinifier;
use Laracasts\Commander\CommandHandler;

class MinifyCommandHandler implements CommandHandler
{
    public function handle($command)
    {
        switch ($command->getType()) {
            case 'js':
                $content = JSMin::minify($command->getContent());
                break;
            case 'css':
                $Buffer = new CssMinifier($command->getContent());
                $content = $Buffer->getMinified();
                break;
        }

        return $content;
    }
} 