<?php


namespace App\Controller;


use App\Entity\Recettes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteRecettesController extends AbstractController
{
    /**
     * @Route("/deleteRecette/{id}", name="delete_recette", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $recette = $this->getDoctrine()->getRepository(Recettes::class)->findOneBy(['id' => $id]);

        $manager->remove($recette);
        $manager->flush();

        return new JsonResponse(['message' => 'Recette supprimé'], Response::HTTP_OK);
    }
}