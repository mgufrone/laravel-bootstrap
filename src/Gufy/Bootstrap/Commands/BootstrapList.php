<?php namespace Gufy\Bootstrap\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BootstrapList extends Command {

	protected $name = 'bootstrap:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List of available asset that can be registered.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
		$structure = __DIR__ . '/../../../../structure';
		$this->info("Available Assets: ");
		foreach(scandir($structure) as $dir)
		{
			if($dir !='.' && $dir != '..')
			$this->info("\t- ".$dir);
		}
		$this->info('To install asset, type php artisan bootstrap:install asset_name');
	}

}