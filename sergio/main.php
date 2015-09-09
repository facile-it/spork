<?php

main();

function main() {
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/SergioRunner.php';

    $output = fopen('php://stdout', 'w+');

    $failingProcesses = [
        1 => false,
        2 => false,
        3 => true,
        4 => false,
        5 => false,
        6 => false,
        7 => false,
    ];

    $runner = new SergioRunner($output, $failingProcesses);

    $manager = new \Spork\ProcessManager();
    $batch = $manager->createBatchJob(array_keys($failingProcesses));

    /** @var \Spork\Fork $promise */
    $promise = $batch->execute(function ($pId) use ($runner) {
        $runner->setProcessId($pId);
        $runner->run($pId);
    });

    echo 'Main process waiting...' . PHP_EOL;
    $promise->wait();

    $promise->done(function () {
        echo 'Promise Success!' . PHP_EOL;
    });
    $promise->fail(function () {
        echo 'Promise Failed!' . PHP_EOL;
    });
}
