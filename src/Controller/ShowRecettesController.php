<?php


namespace App\Controller;


use App\Entity\Ingredient;
use App\Entity\Recettes;
use App\Repository\IngredientRepository;
use App\Repository\RecettesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShowRecettesController extends AbstractController
{
    /**
     * @Route("/showRecettes", name="show_recettes", methods={"GET"})
     */
    public function showRecettes(RecettesRepository $recettesRepository):JsonResponse
    {
        $recettes = $recettesRepository->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);

        $data = $serializer->normalize($recettes, null, [AbstractNormalizer::ATTRIBUTES => ['Titre','sousTitre', 'ingredients' => ['name']]]);

        $response = new JsonResponse(['recettes' => $data], 200);

        return $response;

    }


}