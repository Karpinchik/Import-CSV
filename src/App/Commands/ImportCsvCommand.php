<?php
declare(strict_types=1);

namespace App\App\Commands;

use App\Service\ImportCsv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\Table;

/**
 * Main command to import CSV
*/
final class ImportCsvCommand extends Command
{
    /**
     * @var object object for initializing main method application
     */
    private object $process;

    /**
     * @param ImportCsv $process
    */
    public function __construct(ImportCsv $process)
    {
        parent::__construct();
        $this->process = $process;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('command:import')
            ->setDescription('This command import CSV in DB.')
            ->addArgument('test', InputArgument::OPTIONAL)
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) :int
    {
        $io = new SymfonyStyle($input, $output);
        // здесь можно изменить аргументы проверки с str на bool
        $argument = $input->getArgument('test') ?? 'no argument';

        do {
            $pathFile = $io->ask('The path to CSV-file');
        } while ($pathFile === null);

        $arrayFilterData = $this->process->processImport($pathFile, $argument);

        if(empty($arrayFilterData['countRelevantItems'])) {
            $io->error('not get data');

            return 0;
        }

        if($arrayFilterData['status add'] == true) {
            $io->success('DB OK');
        } else {
            $io->note('Data not added to DB');
        }

        $incr = $arrayFilterData['incorrectItems'];
        $headers = $arrayFilterData['headers'];
        $output->writeln(['All got products - ',]);
        $output->writeln($arrayFilterData['countAllItems']);
        $output->writeln(['',]);
        $output->writeln(['Relevant products - ',]);
        $output->writeln($arrayFilterData['countRelevantItems']);
        $output->writeln(['',]);
        $output->writeln(['All incorrect products - ',]);
        $output->writeln($arrayFilterData['countIncorrectItems']);
        $output->writeln(['',]);
        $output->writeln(['Not import these items',]);
        $table = new Table($output);
        $roles = [];

        foreach ((array)$incr as $items=> $item){
            array_push($roles, $item);
        }

        $table
            ->setHeaders([$headers])
            ->setRows($roles)
        ;
        $table->render();

        return 1;
    }
}


