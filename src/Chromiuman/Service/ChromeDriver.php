<?php
namespace Chromiuman\Service;

class ChromeDriver
{

    /**
     * @var
     */
    private $resource;

    /**
     * @var
     */
    private $pipes;

    /**
     * @var array
     */
    private $config;

    public function __construct($conf)
    {
        $this->config = $conf;
    }

    /**
     * Start chromedriver
     */
    public function startChromeDriver() {
        $command = $this->getCommand();

        $descriptorSpec = array(
            array('pipe', 'r'),
            array('file', $this->config['logDir'] . 'chromedriver.output.txt', 'w'),
            array('file', $this->config['logDir'] . 'chromedriver.errors.txt', 'a')
        );


        $this->resource = proc_open($command, $descriptorSpec, $this->pipes, null, null, array('bypass_shell' => true));
    }

    /**
     * Stops chromedriver
     * @return array
     */
    public function stopChromeDriver() {

        $messages = [];
        if ($this->resource !== null) {
            $messages[] = 'Stopping Chromedriver';
            // Wait till the server has been stopped
            $max_checks = 10;
            for ($i = 0; $i < $max_checks; $i++) {
                // If we're on the last loop, and it's still not shut down, just
                // unset resource to allow the tests to finish
                if ($i == $max_checks - 1 && proc_get_status($this->resource)['running'] == true) {
                    $messages[] = PHP_EOL;
                    $messages[] = 'Unable to properly shutdown Chromedriver';
                    unset($this->resource);
                    break;
                }
                // Check if the process has stopped yet
                if (proc_get_status($this->resource)['running'] == false) {
                    $messages[] = PHP_EOL;
                    $messages[] = 'Chromedriver stopped';
                    unset($this->resource);
                    break;
                }
                foreach ($this->pipes as $pipe) {
                    if (is_resource($pipe)) {
                        fclose($pipe);
                    }
                }
                // Terminate the process
                // Note: Use of SIGINT adds dependency on PCTNL extension so we
                // use the integer value instead
                proc_terminate($this->resource, 2);

                // Wait before checking again
                sleep(1);
            }
        }
        return $messages;
    }


    protected function getCommand() {

        $params = [
            '--url-base=wd/hub'
        ];

        $commandPrefix = $this->isWindows() ? '' : 'exec ';
        return $commandPrefix . escapeshellarg(realpath($this->config['path'])) . ' ' . implode(' ', $params);
    }

    /**
     * Checks if the current machine is Windows.
     *
     * @return bool True if the machine is windows.
     * @see http://stackoverflow.com/questions/5879043/php-script-detect-whether-running-under-linux-or-windows
     */
    private function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}