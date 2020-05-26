<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class DomainMaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Model application';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $stub;
    protected $file;

    public function __construct(DomainStub $stub, Filesystem $file)
    {
        parent::__construct();
        $this->stub = $stub;
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createDomainDirectory()
             ->makeModel()
             ->makeRepository()
             ->makeDbRepository();

        $this->info('Model, model, repository and DbRepository are created successfully');
    }

    protected function createDomainDirectory()
    {
        $this->file->makeDirectory(
            app_path('Model') . '/' . $this->stub->className($this->argument('domain')),
            0755, true, true
        );

        return $this;
    }

    protected function getPath($key)
    {
        $domain_path = app_path('Model');
        $domain = $this->stub->className($this->argument('domain'));

        switch ($key) {
            case 'model':
                return "{$domain_path}/{$domain}/{$domain}.php";
            break;

            case 'interface':
                return "{$domain_path}/{$domain}/{$domain}Repository.php";
            break;

            case 'repository':
                return "{$domain_path}/{$domain}/Db{$domain}Repository.php";
            break;
        }
    }
    
    /**
     * Make model file in domain.
     */
    protected function makeModel()
    {
        $this->file->put(
            $this->getPath('model'), 
            $this->stub->compileStub('model', 'domain', $this->stub->className($this->argument('domain')))
        );

        return $this;
    }

    protected function makeRepository()
    {
        $this->file->put(
            $this->getPath('interface'), 
            $this->stub->compileStub('interface', 'domain', $this->stub->className($this->argument('domain')))
        );

        return $this;
    }

    protected function makeDbRepository()
    {
        $this->file->put(
            $this->getPath('repository'), 
            $this->stub->compileStub('repository', 'domain', $this->stub->className($this->argument('domain')))
        );

        return $this;
    }

}
