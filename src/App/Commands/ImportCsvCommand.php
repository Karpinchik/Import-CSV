<?php
declare(strict_types=1);

namespace App\App\Commands;

use App\Entity\Product;
use App\Service\Analyze;
use App\Service\ImportCsv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Controller\CheckCsvInputController;

final class ImportCsvCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('command:import')
            ->setDescription('This command will ask you for name and surname and print them back.')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        do {
            $pathFile = $io->ask('The path to CSV-file');
        } while ($pathFile === null);

        $importCsvService = new ImportCsv();
        $res = $importCsvService->processImport();

        // надо запустить основной класс и передать

//        $importService = new CheckCsvInputController();
//// set value in properties
//        $importService->setPathCsv($pathFile);
//// checked valid format
//        $checkFormat = $importService->checkFormat($pathFile);
//
//        if($checkFormat == 0) {
//            $io->success('This command is working only .csv');
//        }
//
//        $readFile = new ReadCsvController();
//
//        $readFile->setPathCsv($pathFile);
//
//        $res = $readFile->deserializeFile($pathFile);
//
        $io->success($res);

        return 1;
    }
}



