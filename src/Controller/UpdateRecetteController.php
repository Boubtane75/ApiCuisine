<?php


namespace App\Controller;


use App\Entity\Ingredient;
use App\Entity\Recettes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UpdateRecetteController extends AbstractController
{
    /**
     * @Route("/updateRecettes/{id}", name="update_recettes", methods={"PUT"})
     */
    public function UpdateRecettes($id, Request $request):JsonResponse
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        $manager = $this->getDoctrine()->getManager();
        $recette = $this->getDoctrine()->getRepository(Recettes::class)->findOneBy(['id'=>$id]);
        $titre = $request->get('titre');
        $sousTitre = $request->get('sousTitre');
        //ingredients est un tableau avec une key = id en base de la table ingredient et la valeur = name
        //$ingredients [$key = id => $value = name]
        $ingredients = $request->get('ingredients');
        if (empty($titre) || empty($ingredients))
        {
            throw new NotFoundHttpException('Les paramètres obligatoires sont attendus!');
        }

        $recette->setTitre($titre)
            ->setSousTitre($sousTitre);
        foreach ($ingredients as $key => $value)
        {
            $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->findOneBy(['id'=>$key]);
            $ingredient->setName($value);
            $manager->persist($recette);
        }

        $manager->persist($recette);
        $manager->flush();
        $data = $serializer->normalize($recette, null, [AbstractNormalizer::ATTRIBUTES => ['Titre','sousTitre', 'ingredients' => ['name']]]);
        return new JsonResponse(['Update',$data], Response::HTTP_OK);
    }


}