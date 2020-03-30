<?php namespace Bariew\Translator\Services;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

/**
 * The TranslatorService class.
 *
 * @author bariew <bariew@yandex.ru>
 */
class TranslatorService
{
    /**
     * @var Application
     */
    public $app;
    public $config = [];


    /**
     * TranslatorService constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = $app['config']['translator'];
    }

    public function import()
    {
        $base = $this->app['path.lang'];
        $vendor = false;
        $files = Finder::create()->in(array_map(function ($v) {
            return base_path() . $v;
        }, $this->config['include']))->ignoreDotFiles(true)->notPath($this->config['exclude'])->files();
        $keys = [];

        foreach ($files as $file) {
            if (!preg_match_all('/(\?=\s*__|echo\s*__|{{\s*__|{{\s*\@lang)\([\'\"]([^\'\"]+)[\'\"]\)/', file_get_contents($file), $matches)) {
                continue;
            }
            foreach ($matches[2] as $match) {
                $data = array_reverse(explode('.', $match));
                $res = '';
                foreach ($data as $k => $v) {
                    $res = [$data[$k] => $res];
                }
                $keys = array_merge_recursive($keys, $res);
            }
        }

        foreach (Finder::create()->in($this->app['path.lang'])->directories() as $directory) {
            foreach ($keys as $name => $data) {
                $path = $directory . DIRECTORY_SEPARATOR . $name . '.php';
                if (file_exists($path)) {
                    $oldData = require $path;
                    $data = array_merge_recursive($data, $oldData);
                }
                file_put_contents($path, '<?php return ' . var_export($data, true) . ';');
            }
        }

        return true;
    }
}
