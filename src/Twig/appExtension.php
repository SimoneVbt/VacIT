<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends AbstractExtension
{
    private $templating;

    public function getFilters() {
        return [
            new TwigFilter("datum", [$this, 'dutchDate'])
        ];
    }

    public function dutchDate()
    {
        //...
    }
}