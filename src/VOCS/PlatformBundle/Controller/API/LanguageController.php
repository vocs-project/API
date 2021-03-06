<?php
namespace VOCS\PlatformBundle\Controller\API;


use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use VOCS\PlatformBundle\Entity\Language;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class LanguageController extends Controller
{

    /**
     *  @ApiDoc(
     *     section="Language",
     *  description="Récupère tous les langages",
     *  output= { "class"=Language::class, "collection"=true }
     *  )
     *
     * @Rest\View()
     * @Rest\Get("/rest/languages")
     */
    public function getLanguagesAction(Request $request)
    {
        $languages = $this->getDoctrine()->getRepository(Language::class)->findAll();

        return $languages;
    }
}