<?php
/**
 * @author: Raul Rodriguez - raulrodriguez782@gmail.com
 * @created: 7/8/13 - 9:26 AM
 * 
 */

namespace spec\D4m\TerminalNotifier\Console\Command;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\HelperSet;

use D4m\TerminalNotifier\Console\Application;
use D4m\TerminalNotifier\ServiceContainer;

class NotifyCommandSpec extends ObjectBehavior
{

    function it_should_notify_a_string_message(Application $application, ServiceContainer $container,
        HelperSet $helperSet)
    {
        $container->get('console.notifier.path')->shouldBeCalled()->willReturn('bin/phpnotifier');
        $this->setHelperSet($helperSet);
        $application->getHelperSet()->shouldBeCalled()->willReturn($helperSet);
        $application->getContainer()->shouldBeCalled()->willReturn($container);
        $this->setApplication($application);

        $expectedCommandString = "bin/phpnotifier -message \"hello terminal\" ";
        $options = array( 'message' => '=hello terminal');

        $this->getArgumentsString($options)->shouldReturn($expectedCommandString);
    }

    function it_should_notify_a_message_with_title(Application $application, ServiceContainer $container,
        HelperSet $helperSet)
    {
        $container->get('console.notifier.path')->shouldBeCalled()->willReturn('bin/phpnotifier');
        $this->setHelperSet($helperSet);
        $application->getHelperSet()->shouldBeCalled()->willReturn($helperSet);
        $application->getContainer()->shouldBeCalled()->willReturn($container);
        $this->setApplication($application);

        $expectedCommandString = "bin/phpnotifier -message \"hello terminal\" -title \"PhpSpec\" ";
        $options = array(
            'message' => '=hello terminal',
            'title' => '=PhpSpec'
        );

        $this->getArgumentsString($options)->shouldReturn($expectedCommandString);

    }
}