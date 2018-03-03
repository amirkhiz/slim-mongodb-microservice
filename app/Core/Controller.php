<?php
/**
 * Created by Siavash Habil.
 * email: Siavash Habil <amirkhiz@gmail.com>
 */

namespace App\Core;

use App\Traits\Validation;
use Psr\Container\ContainerInterface;

class Controller
{
    use Validation;

    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * Config settings
     */
    protected $settings;

    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    protected $router;

    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected $mongodb;

    /**
     * BaseController constructor.
     *
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->settings  = $this->container['settings'];
        $this->router    = $this->container['router'];
        $this->mongodb   = $this->container['mongodb'];
    }
}