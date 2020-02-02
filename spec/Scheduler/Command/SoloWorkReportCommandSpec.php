<?php

namespace spec\Scheduler\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument\Token\AnyValuesToken;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Scheduler\Command\SoloWorkReportCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SoloWorkReportCommandSpec extends ObjectBehavior
{
    public function let(
        InputInterface $input,
        LoggerInterface $logger
    ) {
        $input->bind(new AnyValuesToken())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();
        $input->hasArgument('command')->willReturn(false);
        $input->hasArgument('rotaId')->willReturn(1);

        $this->beConstructedWith($logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SoloWorkReportCommand::class);
        $this->shouldHaveType(Command::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldReturn('report:soloWork');
    }

    public function it_reports_the_number_of_minutes_in_an_entirely_solo_shift(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->run($input, $output);
    }
}
