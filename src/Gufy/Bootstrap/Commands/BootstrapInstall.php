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
		$structure = __DIR__ . '/../../../../structure';
        $base = base_path();

        $this->line('');
        $this->line('Installing bootstrap assets for your apps.');
        $this->line('');

        $this->xcopy(realpath($structure), realpath($base));

        $this->line('');
        $this->line('Rewriting application.js');
        $this->writeJs($base);

        $this->line('');
        $this->line('Rewriting application.css');
        $this->writeCss($base);

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

    private function writeJs($base_path)
    {
    	$file = $base_path.'/app/assets/javascripts/application.js';
    	$contents = file_get_contents($file);

		$data = explode("\n",$contents);

		foreach($data as &$string)
		{
			if($string == '//= require_tree .')
			{
				$string = "//= require bootstrap\n".$string;
			}	
		}

		$contents = implode("\n",$data);

		return file_put_contents($file, $contents);
    }

    private function writeCss($base_path)
    {
    	$file = $base_path.'/app/assets/stylesheets/application.css';
    	$contents = file_get_contents($file);

		$data = explode("\n",$contents);

		foreach($data as &$string)
		{
			if(trim($string) == '*= require_tree .')
			{
				$string = " *= require bootstrap \n".$string;
			}	
		}

		$contents = implode("\n",$data);

		return file_put_contents($file, $contents);
    }
}
