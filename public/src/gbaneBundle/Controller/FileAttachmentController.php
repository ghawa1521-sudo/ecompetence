<?php

namespace gbaneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use gbaneBundle\Entity\FileAttachment;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FileAttachmentController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/files", name="file_list", methods={"GET"})
     */
    public function listAction(): Response
    {
        $files = $this->em->getRepository(FileAttachment::class)->findAll();

        return $this->render('file_attachments/list.html.twig', [
            'files' => $files
        ]);
    }

    /**
     * @Route("/file/upload", name="file_upload", methods={"POST"})
     */
    public function uploadAction(Request $request): JsonResponse
    {
        $uploadedFile = $request->files->get('file');
        if ($uploadedFile instanceof UploadedFile) {
            $fileName = uniqid().'.'.$uploadedFile->guessExtension();
            $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads';

            try {
                $uploadedFile->move($uploadDir, $fileName);

                $fileAttachment = new FileAttachment();
                $fileAttachment->setFilename($fileName);
                $fileAttachment->setFilepath('/uploads/'.$fileName); // Enregistrez le chemin relatif
                $fileAttachment->setUploadedAt(new \DateTime());
                $this->em->persist($fileAttachment);
                $this->em->flush();

                return new JsonResponse(['status' => 'success', 'fileName' => $fileName], 200);
            } catch (FileException $e) {
                return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }

        return new JsonResponse(['status' => 'error', 'message' => 'No file uploaded'], 400);
    }

    /**
     * @Route("/files/delete/{id}", name="file_delete", methods={"DELETE"})
     */
    public function deleteAction(int $id): JsonResponse
    {
        $fileAttachment = $this->em->getRepository(FileAttachment::class)->find($id);

        if ($fileAttachment) {
            $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads';
            $filePath = $uploadDir.'/'.$fileAttachment->getFilename();

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $this->em->remove($fileAttachment);
            $this->em->flush();

            return new JsonResponse(['status' => 'success'], 200);
        }

        return new JsonResponse(['status' => 'error', 'message' => 'File not found'], 404);
    }
}
