<?php namespace Gufy\Bootstrap\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BootstrapInstall extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bootstrap:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Installing bootstrap assets. Including Javascripts, Fonts, and Stylesheets';

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
        $this->line('Installing '.$asset.' assets for your apps.');
        $this->line('');

        $this->xcopy(realpath($structure), realpath($base));

        if(file_exists($structure.'/provider/javascripts'))
        {
	        $this->line('');
	        $this->line('Registering '.$asset.' to application.js');
	        $this->writeJs($asset, $base);
        }

        if(file_exists($structure.'/provider/stylesheets'))
        {
	        $this->line('');
	        $this->line('Registering '.$asset.' to application.css');
	        $this->writeCss($asset, $base);
        }

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

    private function writeJs($asset, $base_path)
    {
    	$file = $base_path.'/app/assets/javascripts/application.js';
    	$contents = file_get_contents($file);

		$data = explode("\n",$contents);

		foreach($data as &$string)
		{
			if($string == "//= require ".$asset)
			{
				$this->info("Javascript Asset of {$asset} already registered, Ignoring");
				break;
			}
			if($string == '//= require_tree .')
			{
				$string = "//= require {$asset} \n".$string;
			}	
		}

		$contents = implode("\n",$data);

		return file_put_contents($file, $contents);
    }

    private function writeCss($asset, $base_path)
    {
    	$file = $base_path.'/app/assets/stylesheets/application.css';
    	$contents = file_get_contents($file);

		$data = explode("\n",$contents);

		foreach($data as &$string)
		{
			if($string == " *= require ".$asset)
			{
				$this->info("Stylesheet Asset of {$asset} already registered, Ignoring");
				break;
			}
			if(trim($string) == '*= require_tree .')
			{
				$string = " *= require ".$asset." \n".$string;
			}	
		}

		$contents = implode("\n",$data);

		return file_put_contents($file, $contents);
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
