<?php

class SergioRunner
{
    private $output;
    private $erroneousProcesses;
    private $processId;

    public function __construct($output, array $erroneousProcesses)
    {
        $this->output = $output;
        $this->erroneousProcesses = $erroneousProcesses;
    }

    public function setProcessId($processId)
    {
        $this->processId = $processId;
    }

    public function run($processId)
    {
        $this->write("Starting subprocess...");

        sleep(rand(1, 5));

        if ($this->erroneousProcesses[$processId]) {
            $this->write("Error!");
            throw new \LogicException('Just a message');
        }

        $this->write("Done");
    }

    private function write($msg)
    {
        fwrite($this->output, "<$this->processId> " . $msg . PHP_EOL);
    }
}
