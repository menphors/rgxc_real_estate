<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

use Symfony\Component\Process\Process;

class DeployCommand extends Command {

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deploy song4ever ';

	protected $process   = null;
	protected $signature = 's4e:deploy {ssh=song4ever.com }';
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$this->process = new Process($this->getEnvoyCommandLine());
		$this->process->setTimeout(3600);
		$this->info(var_dump($this->process));
		$this->process->run(function ($type, $buffer) {

				if (Process::ERR === $type) {
					$this->error($buffer);
				} else {
					$this->info($buffer);
				}
				
			});

		if (!$this->process->isSuccessful()) {
			throw new \RuntimeException($this->process->getErrorOutput());
		}
	}

	/**
	 * [getEnvoyCommandLine description]
	 * @return [type] [description]
	 */
	protected function getEnvoyCommandLine() {

		$configs        = array_except(config('deploy'), ['envoy_path']);
		$configs['ssh'] = $this->argument('ssh')?:$configs['ssh'];
		$options        = $this->buildOption($configs);
		$envoy          = config('deploy.envoy_path');
		return "{$envoy} run deploy {$options}";
	}

	/**
	 * Build options
	 * @param  array $options
	 * @return string
	 */
	protected function buildOption($options) {

		$opts = "";
		foreach ($options as $key => $value) {
			$opts .= sprintf('--%s=%s ', $key, $value);
		}
		return $opts;
	}
}