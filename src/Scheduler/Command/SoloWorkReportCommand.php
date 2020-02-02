<?php

namespace Scheduler\Command;

use Psr\Log\LoggerInterface;
use Scheduler\Processor\SingleManningProcessor;
use Scheduler\Repository\RotaRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SoloWorkReportCommand extends Command
{
    /**
     * @var LoggerInterface Logger
     */
    private $logger;

    /**
     * @var RotaRepository Rota data source
     */
    private $rotaRepository;

    /**
     * @var SingleManningProcessor Single Manning Processor
     */
    private $singleManningProcessor;

    public function __construct(
        LoggerInterface $logger,
        RotaRepository $rotaRepository,
        SingleManningProcessor $singleManningProcessor
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->rotaRepository = $rotaRepository;
        $this->singleManningProcessor = $singleManningProcessor;
    }

    protected function configure()
    {
        $this->setName('report:soloWork')
            ->setDescription('Calculate staff solo work minutes')
            ->addArgument('rota', InputArgument::REQUIRED, 'Rota ID to process solo work for.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Processing Solo Work for Rota ID:</info> '.$input->getArgument('rota'));

        $rotas = $this->rotaRepository->fetchByID(1);

        if (count($rotas) > 0) {
            foreach ($rotas as $rota) {
                $singleMannings = $this->singleManningProcessor->calculateMinutes($rota);

                foreach ($singleMannings as $singleManning){
                    $output->writeln(print_r($singleManning, true));
                }
            }
        }
    }
}
