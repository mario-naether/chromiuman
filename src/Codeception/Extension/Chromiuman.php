<?php

namespace Codeception\Extension;

use Chromiuman\Service\ChromeDriver;
use Codeception\Event\SuiteEvent;
use Codeception\Platform\Extension;

class Chromiuman extends Extension
{
    /** @var array  */
    public static $events = [
        'module.init' => 'moduleInit',
    ];

    /** @var ChromeDriver  */
    protected $chromeDriver;

    /** @var array  */
    protected $config = [];

    /** @var string  */
    protected $defaultPath = 'vendor/bin/chromedriver.exe';

    /**
     * Chromiuman constructor.
     * @param array $config
     * @param array $options
     */
    public function __construct(array $config, array $options)
    {
        parent::__construct($config, $options);

        if (!isset($this->config['path'])) {
            $this->config['path'] = $this->defaultPath;
        }

        $this->config['logDir'] = $this->getLogDir();

        $this->chromeDriver = new ChromeDriver($this->config);
    }

    /**
     * Module Init
     * @param SuiteEvent $e
     */
    public function moduleInit(SuiteEvent $e): void
    {
        $this->startChromeDriver();
    }


    protected function startChromeDriver(): void
    {
        $this->writeln(PHP_EOL);
        $this->writeln('Starting Chromedriver');

        $this->chromeDriver->startChromeDriver();
    }

    protected function stopChromeDriver(): void
    {
        $messages = $this->chromeDriver->stopChromeDriver();
        $this->write($messages);
    }

    public function __destruct()
    {
        $this->stopChromeDriver();
    }
}
