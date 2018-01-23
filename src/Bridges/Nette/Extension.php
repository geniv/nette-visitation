<?php

namespace Visitation\Bridges\Nette;

use Nette\DI\CompilerExtension;
use Visitation\Visitation;


/**
 * Class Extension
 *
 * @author  geniv
 * @package Visitation\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array default values */
    private $defaults = [
        'tablePrefix' => null,
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        $builder->addDefinition($this->prefix('default'))
            ->setFactory(Visitation::class, [$config]);
    }
}
