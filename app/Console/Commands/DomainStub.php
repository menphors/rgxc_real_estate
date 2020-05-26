<?php

namespace App\Console\Commands;

use Illuminate\Filesystem\Filesystem;

class DomainStub
{
    protected $files;
    protected $config;
    protected $stubs = [
        'interface' => '/../stubs/interface.stub',
        'model' => '/../stubs/model.stub',
        'repository' => '/../stubs/repository.stub',
    ];

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }
    
    public function className($arg)
    {
        return ucwords(camel_case($arg));
    }
    
    protected function getStubPath($key)
    {
        return __DIR__.$this->stubs[$key];
    }
    
    protected function getStub($name)
    {
        return $this->files->get($this->getStubPath($name)) ?: '';
    }
    
    public function compileStub($stub, $searches, $replaces)
    {
        $searches = array_map(function($search){
            return "{{".$search."}}";
        }, !is_array($searches) ? [$searches] : $searches);

        $replaces = !is_array($replaces) ? [$replaces] : $replaces;
         
        return str_replace($searches, $replaces, $this->getStub($stub));
    }
}
