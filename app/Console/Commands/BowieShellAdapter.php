<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BowieShellAdapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bowie:shell-adapter {1?} {2?} {3?} {4?} {5?} {6?} {7?} {8?} {9?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Passes bash command to work directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('1')) {
            $command = $this->argument('1') . " " . $this->argument('2') . " " . $this->argument('3') . " " . $this->argument('4') . " " . $this->argument('5') . " " . $this->argument('6');
        } else {
            echo "Make sure to pass the command you wish to run like: bowie:shell-adapter ls";
            die();
        }
        $process = new Process(['/bin/bash', 'shell-adapter.sh'], '/var/www');
        $process->setInput($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        echo "Command execution complete.\n\n";
        echo "";
        echo $process->getOutput();
    }
}
