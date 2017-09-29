<?php
/**
 * Laravel Multi-Language <https://github.com/renatomarinho/laravel-multi-language>.
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace RenatoMarinho\LaravelMultiLanguage;

use Illuminate\Console\Command;

class MultiLanguageListCommand extends Command
{
    use MultiLanguage;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-language:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all languages available for application';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $this->fire();
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->init();
        $this->message();
    }

    public function message()
    {
        $this->line('| ');
        $this->line('| ');
        $this->line('| '.config('app.name').' has '.
            $this->totalLanguages().' languages available');
        $this->line('| ');
        $this->line('| '.$this->availableLanguages());
        $this->line('| ');
        $this->line('| ');
    }

    private function totalLanguages()
    {
        return $this->languages->count();
    }

    private function availableLanguages()
    {
        return $this->languages->implode(' | ');
    }
}
