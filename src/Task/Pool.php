<?php
namespace MultiFork\Task;

/**
 * Manage the pool of tasks to be executed by Manager Class.
 *
 * @author Philippe Vanzin Moreira <pvanzinmoreira@gmail.com>
 * @author Jair Barbosa <jsbjair@gmail.com>
 */
class Pool extends \SplQueue
{
    /**
     * Start a task pool
     * @param array $tasks tasks to be runned at process forks
     */
    public function __construct(array $tasks = [])
    {
        foreach ($tasks as $task) {
            if (!$task instanceof TaskInterface) {
                throw new \Exception("Task is not a instance of TaskInterface.");
            }

            $this->enqueue($task);
        }
    }
}
