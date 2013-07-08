<?php

namespace D4m\TerminalNotifier\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\OutputInterface;

use D4m\TerminalNotifier\ServiceContainer;
use D4m\TerminalNotifier\Console;

class Application extends BaseApplication
{
    private $container;

    public function __construct($version)
    {
        parent::__construct('phpnotifier', $version);

        $this->setupContainer($this->container = new ServiceContainer());
    }

    public function getContainer()
    {
        return $this->container;
    }

    protected function setupContainer(ServiceContainer $container)
    {
        $this->setupConsole($container);
    }

    protected function setupConsole(ServiceContainer $container)
    {
        $container->setShared('console.io', function($c) {
            return new Console\IO(
                $c->get('console.input'),
                $c->get('console.output'),
                $c->get('console.helpers')
            );
        });

        $container->setShared('console.commands.run', function($c) {
            return new Console\Command\NotifyCommand;
        });

        $container->setShared('console.notifier.path', function($c) {
           return __DIR__ .'/../../../../bin/terminal-notifier.app/Contents/MacOS/terminal-notifier';
        });

    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        array_map(
            array($this, 'add'),
            $this->container->getByPrefix('console.commands')
        );

        $this->container->set('console.input', $input);
        $this->container->set('console.output', $output);
        $this->container->set('console.helpers', $this->getHelperSet());

        if (!($name = $this->getCommandName($input))
            && !$input->hasParameterOption('-h')
            && !$input->hasParameterOption('--help')) {
            $argv = $_SERVER['argv'];

            $binstub = array_shift($argv);
            array_unshift($argv, 'notify');
            array_unshift($argv, $binstub);

            $input = new ArgvInput($argv);
        }

        return parent::doRun($input, $output);
    }
}