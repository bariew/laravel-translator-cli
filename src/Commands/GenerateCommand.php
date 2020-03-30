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
class GenerateCommand extends Command {

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
     * @var TranslatorService
     */
    protected $service;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(\Illuminate\Foundation\Application $app)
	{
		parent::__construct();
        $this->service = new TranslatorService($app);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $this->service->import();
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
