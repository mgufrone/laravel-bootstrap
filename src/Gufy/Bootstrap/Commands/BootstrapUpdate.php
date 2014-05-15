<?php namespace Gufy\Bootstrap\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BootstrapUpdate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bootstrap:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update installed assets';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		$asset = $this->argument('assets');
		$structure = __DIR__ . '/../../../../structure/'.$asset;
		if(!file_exists($structure))
			$this->error('Asset '.$asset.' not found. ');
        $base = base_path();

        $this->line('');
        $this->line('Updating '.$asset.' assets for your apps.');
        $this->line('');

        $this->xcopy(realpath($structure), realpath($base));

        $this->line('');
        $this->line('Done. Happy Coding! :-)');
        $this->line('         - Mochamad Gufron');
	}

	private function xcopy($source, $dest)
    {
        $base = base_path();
        foreach ($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST) as $item) {
            if ($item->isDir()) {
                if (!is_dir($dest . '/' . $iterator->getSubPathName())) {
                    mkdir($dest . '/' . $iterator->getSubPathName());
                }
            } else {
                copy($item, $dest . '/' . $iterator->getSubPathName());
                $this->line('   Copying -> ' . str_replace($base, '', $dest . '/' . $iterator->getSubPathName()));
            }
        }
    }

    protected function getArguments()
	{
		return array(
			array('assets', InputArgument::REQUIRED, 'Asset you want to be published. Ex: bootstrap'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
}
