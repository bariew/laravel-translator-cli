<?php namespace Bariew\Translator\Commands;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Bariew\Translator\Services\TranslatorService;
use Symfony\Component\Finder\Finder;

/**
 * The TranslatorGenerateCommand class.
 *
 * @author bariew <bariew@yandex.ru>
 */
class TranslatorGenerateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'translator:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Start the interactive translator.';

    /**
     * The Laravel file provider.
     * @var Illuminate\Support\Facades\File
     */
    protected $file;

    /**
     * The Laravel config provider.
     * @var Illuminate\Support\Facades\Config
     */
    protected $config;

    /**
     * The translator service.
     * @var Bariew\Translator\Services\TranslatorService
     */
    protected $translator;

    /**
     * Missing translations.
     * @var array
     */
    protected $missing;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(File $file, Config $config)
	{
		parent::__construct();
        $this->file = $file;
        $this->config = $config;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $files = $this->file->notPath(['/vendor', '.git', 'node_modules'])->files();

        foreach ($this->translator->getMissing() as $locale => $bundles) {
            foreach ($bundles as $bundle => $keys) {
                $path = app_path()."/lang/$locale/$bundle.php";
                $contents = "<?php\n\nreturn ".var_export($keys, true).";\n";
                $this->file->put($path, $contents);
                $this->info(" > File saved: $path");
            }
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

    /**
     * Return languages files.
     *
     * @return array Array of languages files.
     */
    protected function getLangFiles()
    {
        $messages = array();
        $path = app_path().'/lang';

        if ( ! $this->file->exists($path)) {
            throw new \Exception("${path} doesn't exists!");
        }

        return $this->file->allFiles($path);
    }

}
