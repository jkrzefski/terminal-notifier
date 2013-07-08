<?php

namespace spec\D4m\TerminalNotifier\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use D4m\TerminalNotifier\ServiceContainer;

class ApplicationSpec extends ObjectBehavior
{
    const PHPNOTIFIER_VERSION = 1.0;

    function let()
    {
        $this->beConstructedWith(self::PHPNOTIFIER_VERSION);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('D4m\TerminalNotifier\Console\Application');
    }



}
