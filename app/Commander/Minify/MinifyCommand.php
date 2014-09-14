<?php namespace Assets\Commander\Minify;

class MinifyCommand
{
    protected $content;
    protected $type;

    public function __construct($content, $type)
    {
        $this->type = trim(strtolower($type));
        $this->content = $content;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getContent()
    {
        return $this->content;
    }
} 