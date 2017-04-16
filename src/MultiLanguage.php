<?php
/**
 * Laravel Multi-Language <https://github.com/renatomarinho/laravel-multi-language>.
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace RenatoMarinho\LaravelMultiLanguage;

use File;
use Symfony\Component\Finder\Finder;

trait MultiLanguage
{
    private $appName;
    private $languageKeys;
    private $languages;
    private $languageDirectories;

    public function init()
    {
        $this->setAppName();
        $this->setLanguageDirectories();
        $this->listLanguages();
    }

    private function setAppName()
    {
        $this->appName = strtolower(config('app.name')).'.';
    }

    private function getAppName()
    {
        return $this->appName;
    }

    private function setLanguageDirectories()
    {
        $this->languageDirectories = File::directories(resource_path().'/lang');
    }

    private function listLanguages()
    {
        $this->languages = collect($this->languageDirectories)->map(function ($collection) {
            return basename($collection);
        });

        return collect($this->languages);
    }

    public function generateFile()
    {
        $arr = [];
        $finder = new Finder();
        $finder->in($this->languageDirectories);

        foreach ($finder as $file) {
            $arrFile = include $file;

            foreach ($this->languageKeys as $value) {
                $arr[$value] = $arrFile[$value] ?? $this->getAppName().$value;
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
        $template .= 'return '.var_export($arr, true).';';

        File::put($file, $template);
        $this->line('Put file '.$file);
    }

    private function banner()
    {
        return include 'include/banner.php';
    }

    /*
     * This method is based in Laravel Translation Manager
     * Created by Barry vd. Heuvel
     * GitHub: https://github.com/barryvdh/laravel-translation-manager
     */
    public function find()
    {
        $keys = [];
        $functions = ['trans', 'trans_choice', 'Lang::get', 'Lang::choice', 'Lang::trans',
            'Lang::transChoice', '@lang', '@choice', '__', ];
        $pattern =                              // See http://regexr.com/392hu
            "[^\w|>]".                          // Must not have an alphanum or _ or > before real method
            '('.implode('|', $functions).')'.  // Must start with one of the functions
            "\(".                               // Match opening parenthese
            "[\'\"]".                           // Match " or '
            '('.                                // Start a new group to match:
            '[a-zA-Z0-9_-]+'.                   // Must start with group
            "([.][^\1)]+)+".                    // Be followed by one or more items/keys
            ')'.                                // Close group
            "[\'\"]".                           // Closing quote
            "[\),]";                            // Close parentheses or new parameter

        $finder = new Finder();
        $finder->in(base_path())->exclude('storage')->name('*.php')->files();

        $bar = $this->output->createProgressBar($finder->count());

        $this->line('');
        $this->info('Laravel Multi-Language - Preparing to search in '.$finder->count().' files');
        $this->line('');

        foreach ($finder as $file) {
            if (preg_match_all("/$pattern/siU", $file->getContents(), $matches)) {
                foreach ($matches[2] as $key) {
                    $keys[] = str_replace($this->getAppName(), '', $key);
                }
            }

            $bar->advance();
        }

        $bar->finish();

        $keys = array_unique($keys);
        $this->languageKeys = $keys;

        $this->line('');
        $this->line('');
        $this->info('Found '.count($keys).' sentences');
    }
}
