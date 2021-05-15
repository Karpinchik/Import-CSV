<?php
declare(strict_types=1);

namespace App\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\Table;
use App\Service\ImportCsv;

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
        $isArgumentEnterMode = $input->getArgument('test') === "test" ? true : false;

        do {
            $pathFile = $io->ask('The path to CSV-file');
        } while ($pathFile === null);

            $resultParseData = $this->process->processImport($pathFile, $isArgumentEnterMode);

            if ($resultParseData->hasErrors())
            {
                $io->warning('Data not added in to DB');
                $output->writeln($resultParseData->getErrorResult()->getError());
            } else {

                if ($isArgumentEnterMode == true){
                    $io->note('Test mode!');
                }
                else {
                    $io->success('Data added in to DB');
                }

                $allIncorrectItems = $resultParseData->getImportResult()->getIncorrectItems();
                $headers = $resultParseData->getImportResult()->getHeaders();
                $output->writeln(['All got products ',]);
                $output->writeln([$resultParseData->getImportResult()->getCountAllItems(), '']);
                $output->writeln(['Relevant products ',]);
                $output->writeln([$resultParseData->getImportResult()->getCountRelevantItems(), '']);
                $output->writeln(['All incorrect products ',]);
                $output->writeln([$resultParseData->getImportResult()->getCountIncorrectItems(), '']);
                $output->writeln(['Not import these items',]);
                $table = new Table($output);
                $rows = [];

                if ($allIncorrectItems) {
                    foreach ($allIncorrectItems as $items => $item) {
                        array_push($rows, (array)$item);
                    }

                    $table
                        ->setHeaders($headers)
                        ->setRows($rows)
                    ;
                    $table->render();
                }
            }

        return 1;
    }
}
