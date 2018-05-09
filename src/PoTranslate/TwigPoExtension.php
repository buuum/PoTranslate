<?php

namespace PoTranslate;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigPoExtension extends AbstractExtension
{

    private $translate;

    public function __construct(Translate $translate)
    {
        $this->translate = $translate;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('e', [$this, 'translate'])
        ];
    }

    public function translate($name)
    {
        return $this->translate->translate($name);
    }

}