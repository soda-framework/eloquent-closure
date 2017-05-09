<?php

namespace Soda\ClosureTable\Console;

use Illuminate\Console\Command;
use Soda\ClosureTable\ClosureTableServiceProvider as CT;

/**
 * Basic ClosureTable command, outputs information about the library in short.
 */
class ClosureTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'closuretable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get ClosureTable version notice.';

    /**
     * Executes console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('ClosureTable v'.CT::VERSION);
        $this->line('Closure Table database design pattern implementation for Laravel framework.');
        $this->comment('Copyright (c) 2013-2014 Jan Iwanow');
    }
}
