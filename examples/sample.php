<?php
require __DIR__ . '/../vendor/autoload.php';
require 'ExampleTask.php';

$tasks = [
    new ExampleTask(['id' => 'T1', 'time' => 10]),
    new ExampleTask(['id' => 'T2', 'time' => 5]),
    new ExampleTask(['id' => 'T3', 'time' => 5]),
    new ExampleTask(['id' => 'T4', 'time' => 10]),
    new ExampleTask(['id' => 'T5', 'time' => 8])
];

$manager = new \MultiFork\Manager(new \MultiFork\Task\Pool($tasks), 2);
$manager->init();
