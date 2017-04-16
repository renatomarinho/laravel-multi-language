<?php
/**
 * Laravel Multi-Language <https://github.com/renatomarinho/laravel-multi-language>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace RenatoMarinho\LaravelMultiLanguage;

use Exception;
use File;
use Symfony\Component\Finder\Finder;
use Illuminate\Console\Command;

class MultiLanguageUpdateCommand extends Command
{
    use MultiLanguage;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'multi-language:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all languages available for application';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->init();

        $this->find();
        $this->generateFile();
    }

}
