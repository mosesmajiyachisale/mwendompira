<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeService extends GeneratorCommand
{
    /**
     * The console command name.
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub()
    {
        return base_path('stubs/service.stub');
    }

    /**
     * Get the destination class path.
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of the service',
            ],
        ];
    }

    /**
     * Prepare the name for the generator.
     */
    protected function qualifyClass($name)
    {
        $name = trim($name, '\\/');

        // Remove any leading Services namespace
        $name = preg_replace('/^Services[\\\\\\/]/', '', $name);

        // Append Service if it is not already present
        if (!str_ends_with($name, 'Service')) {
            $name .= 'Service';
        }

        return parent::qualifyClass($name);
    }
}