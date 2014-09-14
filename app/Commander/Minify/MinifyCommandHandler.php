<?php namespace Assets\Commander\Minify;

use JSMin;
use CssMinifier;
use Laracasts\Commander\CommandHandler;

class MinifyCommandHandler implements CommandHandler
{
    public function handle($command)
    {
        $content = $command->getContent();

        switch ($command->getType()) {
            case 'js':
                $content = JSMin::minify($content);
                break;
            case 'css':
                $Buffer = new CssMinifier($content);
                $content = $Buffer->getMinified();
                break;
        }

        return trim($content);
    }
} 