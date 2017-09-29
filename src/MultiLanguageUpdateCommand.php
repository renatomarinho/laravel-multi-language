<?php
/**
 * Laravel Multi-Language <https://github.com/renatomarinho/laravel-multi-language>.
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace RenatoMarinho\LaravelMultiLanguage;

use File;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

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

        $this->find();
        $this->generateFile();
    }

    public function generateFile()
    {
        $arr = [];
        $finder = new Finder();
        $finder->in($this->languageDirectories);

        foreach ($finder as $file) {
            $path = pathinfo($file);
            $arrFile = include $file;
            $arr = [];
            foreach ($this->languageKeys as $value) {
                $exp = explode('.', $value);
                if ($exp[0] == $path['filename']) {
                    $key = str_replace($path['filename'].'.', '', $value);
                    $arr[$key] = $arrFile[$key] ?? $value;
                }
            }

            $this->putFile($file, $arr);
        }
    }

    public function putFile($file, $arr)
    {
        $search = ['{date}', '{lines}'];
        $replace = [date('Y-m-d h:s:i'), count($arr)];

        $template = '<?php ';
        $template .= "\n";
        $template .= str_replace($search, $replace, $this->banner());
        $template .= "\n\r";
        if (!empty($arr)) {
            $template .= 'return '.var_export($arr, true).';';
        }
        File::put($file, $template);
        $this->line('Put file '.$file);
    }
}
