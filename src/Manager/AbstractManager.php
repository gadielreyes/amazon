<?php

namespace App\Manager;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractManager
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(ContainerInterface $container, HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->client = $client;
        $this->logger = $logger;
    }
}
