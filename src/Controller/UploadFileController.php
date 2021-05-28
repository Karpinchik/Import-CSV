<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Service\startCommandImport;
use App\Service\ClearTmpUploadFiles;

class UploadFileController extends AbstractController
{
    /**
     * @Route("/uploads/file", name="upload_file")
     */
    public function upload(Request $request, startCommandImport $commandImport, KernelInterface $kernel,
    ClearTmpUploadFiles $clearTmpUploadFiles): Response
    {
        $form = $this->createFormBuilder()
            ->add('csvFile', FileType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectDir = explode('/', $_SERVER['DOCUMENT_ROOT']);
            $pathUploadDir = array_slice($projectDir, 0, -1);
            $fullPathUploadDir = implode("/", $pathUploadDir) . "/var/uploads/";
            $uploadFile = $fullPathUploadDir . $_FILES['form']['name']['csvFile'];

            if (move_uploaded_file($_FILES['form']['tmp_name']['csvFile'], $uploadFile)) {
                try {
                    $params = $commandImport->write($kernel, $uploadFile);
                } catch (\Exception $exception) {
                    $params = $exception;
                }

                $clearTmpUploadFiles->clearUploadFiles($fullPathUploadDir);

                return $this->render('upload_file/upload.html.twig', [
                    'form' => $form->createView(),
                    'params'=> $params
                ]);
            } else {

                return $this->render('upload_file/upload.html.twig', [
                    'form' => $form->createView(),
                    'params'=> [$_FILES['form']['error']['csvFile']]
                ]);
            }
        } else {

            return $this->render('upload_file/upload.html.twig', [
                'form' => $form->createView(),
                'params'=> ['upload file.csv for added in to DB']
            ]);
        }
    }
}
