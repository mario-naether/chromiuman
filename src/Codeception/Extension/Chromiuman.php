<?php
namespace Codeception\Extension;




use Chromiuman\Service\ChromeDriver;

class Chromiuman extends \Codeception\Platform\Extension
{
    // list events to listen to
    static $events = array(
        'module.init' => 'moduleInit',
    );

    protected $chromeDriver;

    protected $config = [];

    protected $defaultPath = 'vendor/bin/chromedriver.exe';

    public function __construct($config, $options)
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
     */
    public function moduleInit(\Codeception\Event\SuiteEvent $e)
    {
        $this->startChromeDriver();
    }

    protected function startChromeDriver() {

        $this->writeln(PHP_EOL);
        $this->writeln('Starting Chromedriver');

        $this->chromeDriver->startChromeDriver();

    }

    protected function stopChromeDriver() {

        $messages = $this->chromeDriver->stopChromeDriver();
        $this->write($messages);
    }


    public function __destruct()
    {
        $this->stopChromeDriver();
    }
}