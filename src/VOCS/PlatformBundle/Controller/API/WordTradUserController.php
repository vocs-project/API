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
use VOCS\PlatformBundle\Entity\WordTradUser;
use VOCS\PlatformBundle\Form\WordTradUserType;


class WordTradUserController extends Controller {
    /**
     * PUT
     */

    /**
     * @ApiDoc(
     *     section="WordTradUser",
     *    description="Change une WordTradUser",
     *    input={"class"=WordTradUsersType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"WordTradUser"})
     * @Rest\Put("/rest/wordTradUsers/{id}")
     */
    public function putWordTradUsersAction(Request $request)
    {
        return $this->updateWordTradUser($request, true);
    }

    /**
     * @ApiDoc(
     *     section="WordTradUser",
     *    description="Patch un stat d'un user pour un wordTrad",
     *    input={"class"=WordTradUserType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"wordtraduser"})
     * @Rest\Patch("/rest/wordTradUsers/{id}")
     */
    public function patchWordTradUsersAction(Request $request)
    {
        return $this->updateWordTradUser($request, false);
    }


    private function updateWordTradUser(Request $request, $clearMissing) {
        $WordTradUser = $this->getDoctrine()->getRepository(WordTradUser::class)->find($request->get('id'));


        $form = $this->createForm(WordTradUserType::class, $WordTradUser);

        $form->submit($request->request->all(), $clearMissing);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $WordTradUser;
        } else {
            return $form;
        }
    }

}