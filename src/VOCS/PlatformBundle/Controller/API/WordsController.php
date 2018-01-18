<?php
namespace VOCS\PlatformBundle\Controller\API;

use FOS\RestBundle\View\View;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use VOCS\PlatformBundle\Entity\Words;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use VOCS\PlatformBundle\Form\WordsType;

class WordsController extends Controller
{

    /**
     * GET
     */

    /**
     * @ApiDoc(
     *     section="Words",
     *     description="Récupère toutes les mots",
     *     output= { "class"=Words::class, "collection"=true, "groups"={"word"} }
     *     )
     *
     * @Rest\View(serializerGroups={"word"})
     * @Rest\Get("/rest/words")
     */
    public function getWordsAction(Request $request) {
        $words = $this->getDoctrine()->getRepository(Words::class)->findAll();
        return $words;
    }

    /**
     * POST
     */

    /**
     *  @ApiDoc(
     *     section="Words",
     *    description="Crée un mot ",
     *    input={"class"=WordsType::class, "name"="", "groups"={"word"}}
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"word"})
     * @Rest\Post("/rest/words")
     *
     */
    public function postWordsAction(Request $request) {
        $word = new Words();

        $form = $this->createForm(WordsType::class, $word);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tWord = $em->getRepository(Words::class)->findBy(array('content' => $word->getContent(), 'language' => $word->getLanguage()));
            if($tWord != null) {
                foreach ($word->getTrads() as $trad) {
                    $tWord->addTrad($trad);
                }
                return $tWord;
            }
            $em->persist($word);
            $em->flush();

            return $word;
        } else {
           return $form;
        }

    }


    /**
     * PUT
     */

    /**
     * @ApiDoc(
     *     section="Words",
     *    description="Change une worde",
     *    input={"class"=WordsType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"word"})
     * @Rest\Put("/rest/words/{id}")
     */
    public function putWordsAction(Request $request)
    {
        return $this->updateWord($request, true);
    }

    /**
     * @ApiDoc(
     *     section="Words",
     *    description="Patch une worde",
     *    input={"class"=WordsType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"word"})
     * @Rest\Patch("/rest/words/{id}")
     */
    public function patchWordsAction(Request $request)
    {
        return $this->updateWord($request, false);
    }


    private function updateWord(Request $request, $clearMissing) {
        $word = $this->getDoctrine()->getRepository(Words::class)->find($request->get('id'));

        if (empty($word)) {
            return new JsonResponse(['message' => 'Word not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(WordsType::class, $word);

        $form->submit($request->request->all(), $clearMissing);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->merge($word);
            $em->flush();

            return $word;
        } else {
            return $form;
        }
    }
}