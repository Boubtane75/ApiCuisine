<?php
namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Recettes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddRecettesController extends AbstractController
{
    /**
     * @Route("/addRecettes", name="add_recettes", methods={"POST"})
     */
    public function AddRecettes(Request $request):JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $Titre =$request->get('titre');
        $SousTitre = $request->get('sousTitre');
        $Ingredients = $request->get('ingredients');
        if (empty($Titre) || empty($Ingredients)){
            throw new NotFoundHttpException('Les paramètres obligatoires sont attendus!');
        }

        $Recettes = new Recettes();
        $Recettes->setTitre($Titre)
            ->setSousTitre($SousTitre);

        $manager->persist($Recettes);
        foreach ($Ingredients as $ingredient)
        {
            $resIngredient = new Ingredient();
            $resIngredient->setName($ingredient)
                ->addRecette($Recettes);
            $manager->persist($resIngredient);
        }
        $manager->flush();

        return new JsonResponse(['message' => 'Recette ajouter !'], Response::HTTP_CREATED);

    }
}