<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TestLogStreaming extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:log-streaming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints Hello.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $this->fileLogDev('Starting');

        // $this->fileLogDev('Console Output');
        // $this->line('<info>'.date('Y-m-d H:i:s').' - Console Output -> Saying Hello !!!</info>');

        // $this->fileLogDev('PHP Echo');
        // echo date('Y-m-d H:i:s'). " - PHP Echo -> Saying Hello !!!" . PHP_EOL;

        $this->fileLogDev('Log Default');
        Log::info(date('Y-m-d H:i:s').' - Logging default info() -> Saying Hello !!!');
        Log::error(date('Y-m-d H:i:s').' - Logging default error() -> Saying Hello !!!');

        // $this->fileLogDev('Log Channel stderr');
        // Log::channel('stderr')->info(date('Y-m-d H:i:s'). ' - Logging stderr info() -> Saying Hello');
        // Log::channel('stderr')->error(date('Y-m-d H:i:s'). ' - Logging stderr error() -> Saying Hello');

        // $this->fileLogDev('Log Channel syslog');
        // Log::channel('syslog')->info(date('Y-m-d H:i:s'). ' - Logging syslog info() -> Saying Hello');
        // Log::channel('syslog')->error(date('Y-m-d H:i:s'). ' - Logging syslog error() -> Saying Hello');

        // $this->fileLogDev('Log Channel errorlog');
        // Log::channel('errorlog')->info(date('Y-m-d H:i:s'). ' - Logging errorlog info() -> Saying Hello');
        // Log::channel('errorlog')->error(date('Y-m-d H:i:s'). ' - Logging errorlog error() -> Saying Hello');

        // $this->fileLogDev('PHP error_log()');
        // error_log(date('Y-m-d H:i:s').' - PHP error_log() -> Saying Hii !!!');

        // $this->fileLogDev('exec()');
        // exec('echo "'.date('Y-m-d H:i:s').' - exec(/proc/1/fd/1) -> Saying Hello !!!'.PHP_EOL.'" > /proc/1/fd/1');
        // exec('echo "'.date('Y-m-d H:i:s').' - exec(/proc/1/fd/2) -> Saying Hello !!!'.PHP_EOL.'" > /proc/1/fd/2');

        // $this->fileLogDev('fopen(/proc/1/fd/2)');
        // $procfd = fopen('/proc/1/fd/2', 'w');
        // fwrite($procfd, date('Y-m-d H:i:s'). ' - fopen(/proc/1/fd/2) -- Saying Hello !!' . PHP_EOL);
        // fclose($procfd);

        // $this->fileLogDev('fopen(php://fd/1)');
        // $fd1 = fopen('php://fd/1', 'w');
        // fwrite($fd1, date('Y-m-d H:i:s'). ' - fopen(php://fd/1) -- Saying Hello !!' . PHP_EOL);
        // fclose($fd1);

        // $this->fileLogDev('fopen(php://stderr)');
        // $err = fopen('php://stderr', 'w');
        // fwrite($err, date('Y-m-d H:i:s'). ' - fopen(php://stderr) -- Saying Hello !!' . PHP_EOL);
        // fclose($err);

        // $this->fileLogDev('Ending');
    }

    protected function fileLogDev($msg)
    {
        File::append(storage_path('logs/appends.log'), date('Y-m-d H:i:s.u').' - '.$msg.' !!!'.PHP_EOL);
    }
}
