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
		if(empty($asset))
		{
			return $this->massUpdate();
		}
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
			array('assets', InputArgument::OPTIONAL, 'Asset you want to be published. Ex: bootstrap'),
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

	private function massUpdate()
	{
		$this->line("Let me get what you're already installed");
		$structure = __DIR__ . '/../../../../structure/';
		$provider_list = array();

		foreach(scandir($structure) as $dir)
			if($dir != '.' && $dir != '..')
				$provider_list[] = $dir;

		$this->line("Looking at application.js");
		$file = $base_path.'/app/assets/javascripts/application.js';
    	$contents = file_get_contents($file);

		$data = explode("\n",$contents);

		foreach($data as $line)
		{
			if(in_array($asset = str_replace("//= require ", "", $line), $provider_list))
			{
				$packages[] = $asset;
			}
		}

		$this->line("Looking at application.css");
		$file = $base_path.'/app/assets/stylesheets/application.css';
    	$contents = file_get_contents($file);

		$data = explode("\n",$contents);

		foreach($data as $line)
		{
			if(in_array($asset = str_replace(" *= require ", "", $line), $provider_list))
			{
				$packages[] = $asset;
			}
		}

		$this->line("Found. Updating ".implode(",", $packages));
		foreach($packages as $package)
		{
			$this->call('bootstrap:update',array('assets'=>$package));
		}

		$this->line('All update is doing fine. Happy Coding');
	}
}
