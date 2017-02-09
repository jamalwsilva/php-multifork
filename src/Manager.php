<?php
namespace MultiFork;

use MultiFork\Task\Pool;

/**
 * Manage all fork processes.
 *
 * @author Philippe Vanzin Moreira <pvanzinmoreira@gmail.com>
 * @author Jair Barbosa <jsbjair@gmail.com>
 */
class Manager
{
    /**
     * Pool of tasks to be executed
     * @var Pool
     */
    private $pool;

    /**
     * Maximum forks to be opened
     * @var int
     */
    private $maxForks;

    /**
     * Current running tasks
     * @var array
     */
    private $running = [];

    /**
     * Define the pool of tasks and max forks to be executed in parallel
     * @param Pool    $pool pool of tasks to be executed
     * @param integer $maxForks maximum forks to be opened
     */
    public function __construct(Pool $pool, $maxForks = 5)
    {
        $this->pool = $pool;
        $this->maxForks = $maxForks;
    }

    /**
     * Init the fork process
     * @return void
     */
    public function init()
    {
        while (!$this->pool->isEmpty()) {
             $this->run();
        }

        $this->wait();
    }

    /**
     * Control the maximum forks on current process
     * @return void
     */
    private function run()
    {
        while (count($this->running) < $this->maxForks && !$this->pool->isEmpty()) {
            $task = $this->pool->shift();
            $pid = $this->fork($task);
            $this->running[$pid] = true;
        }

        if ($this->wait()) {
            return;
        }
    }

    /**
     * Wait for the end of the process (childs)
     * @return boolean
     */
    private function wait()
    {
        while (($endedPid = pcntl_wait($status)) != -1) {
            unset($this->running[$endedPid]);
            return true;
        }
    }

    /**
     * Create a fork from the current process
     * @param  TaskInterface $task task to be executed
     * @return int
     */
    private function fork($task)
    {
        $pid = pcntl_fork();

        if ($pid == 0) {
            if ($task->run()) {
                $task->success();
                exit(0);
            }

            $task->fail();
            exit(1);
        } elseif ($pid == -1) {
            throw new \Exception('Could not fork process.');
        }

        return $pid;
    }
}
