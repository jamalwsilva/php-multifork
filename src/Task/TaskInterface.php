<?php
namespace MultiFork\Task;

/**
 * Interface to be implemented by all tasks
 *
 * @author Philippe Vanzin Moreira <pvanzinmoreira@gmail.com>
 * @author Jair Barbosa <jsbjair@gmail.com>
 */
interface TaskInterface
{
    /**
     * Constructor to create a task
     * @param array $options data
     */
    public function __construct();

    /**
     * Run the task logic
     * @return void
     */
    public function run();

    /**
     * Success callback
     * @return void
     */
    public function success();

    /**
     * Fail callback
     * @return void
     */
    public function fail();
}
