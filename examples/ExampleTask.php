<?php
class ExampleTask implements \MultiFork\Task\TaskInterface
{
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function getId()
    {
        return $this->options['id'];
    }

    public function success()
    {
        echo "Success callback...", PHP_EOL;
    }

    public function fail()
    {
        echo "Error callback...", PHP_EOL;
    }

    public function run()
    {
        sleep($this->options['time']);
        echo '[Pid:' . getmypid() . '][Time: '.$this->options['time'].'][Id: '.$this->getId().']', PHP_EOL;
        return true;
    }
}
