<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class startCommandImport extends AbstractController
{
    /**
     * @param KernelInterface $kernel
     * @return array
     */
    public function write(KernelInterface $kernel, $uploadFile) :array
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput([
            'command' => 'command:import',
            'path' => $uploadFile
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);
        $content = $output->fetch();
        $content = explode(PHP_EOL, $content);

        return $content;
    }
}
