<?php

namespace D4m\TerminalNotifier\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyCommand extends Command
{
    public function __construct()
    {
        parent::__construct('notify');

        $this->setDefinition(array(
            new InputOption('message','m', InputOption::VALUE_REQUIRED, 'Message to Notify'),
            new InputOption('title','t', InputOption::VALUE_REQUIRED, 'Title'),
            new InputOption('subtitle','s', InputOption::VALUE_REQUIRED, 'Subtitle'),
            new InputOption('group','g', InputOption::VALUE_REQUIRED, 'Group ID'),
            new InputOption('remove','r', InputOption::VALUE_REQUIRED, 'Remove specified Group ID'),
            new InputOption('format', 'f', InputOption::VALUE_REQUIRED, 'Formatter'),
        ));
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $options = $input->getOptions();
        $commandString = $this->getArgumentsString($options);

        shell_exec("{$commandString}");
    }

    public function getArgumentsString($options)
    {
        $container = $this->getApplication()->getContainer();
        $binPath = $container->get('console.notifier.path');
        $arguments = array('message', 'title', 'subtitle', 'group', 'remove');
        $shortcuts = array('m', 't', 's', 'g', 'r');
        $inputs = array_merge($arguments, $shortcuts);

        $argumentsString = "";

        foreach($options as $key => $optionValue) {
            if( in_array($key, $inputs, true) ) {
                $argumentsString .= '-'.$key.' "'.$optionValue.'" ';
            }

        }

        $commandString = "{$binPath} {$argumentsString}";

        return $commandString;

    }
}
