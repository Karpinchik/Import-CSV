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
use App\ImportData\ImportResult;

/**
 * Main command to import CSV
*/
final class ImportCsvCommand extends Command
{
    /**
     * @var ImportCsv object for initializing main method application
     */
    private ImportCsv $process;

    /**
     * @param ImportCsv $process
    */
    public function __construct(ImportCsv $process)
    {
        parent::__construct();
        $this->process = $process;
    }

    /**
     * @var ImportResult
    */
    public ImportResult $objFilterData;

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
        $argumentEnterMode = $input->getArgument('test') == "test" ? true : false;

        do {
            $pathFile = $io->ask('The path to CSV-file');
        } while ($pathFile === null);

        $this->objFilterData = $this->process->processImport($pathFile, $argumentEnterMode);

        if($argumentEnterMode == true){
            $io->note('Data not added. Test mode!');
        }
        else {
            $io->success('Data added in to DB');
        }

        $incr = $this->objFilterData->getIncorrectItems();
        $headers = (array)$this->objFilterData->getHeaders();
        $output->writeln(['All got products ',]);
        $output->writeln($this->objFilterData->getCountAllItems());
        $output->writeln(['',]);
        $output->writeln(['Relevant products ',]);
        $output->writeln($this->objFilterData->getCountRelevantItems());
        $output->writeln(['',]);
        $output->writeln(['All incorrect products ',]);
        $output->writeln($this->objFilterData->getCountIncorrectItems());
        $output->writeln(['',]);
        $output->writeln(['Not import these items',]);
        $table = new Table($output);
        $roles = [];

        if ($incr) {
            foreach ((array)$incr as $items => $item) {
                array_push($roles, (array)$item);
            }

            $table
                ->setHeaders($headers)
                ->setRows($roles)
            ;
            $table->render();
        }

        return 1;
    }
}
