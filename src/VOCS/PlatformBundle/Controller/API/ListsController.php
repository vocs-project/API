<?php
namespace VOCS\PlatformBundle\Controller\API;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

use VOCS\PlatformBundle\Entity\Lists;
use VOCS\PlatformBundle\Entity\Words;
use VOCS\PlatformBundle\Entity\WordTrad;
use VOCS\PlatformBundle\Entity\WordTradUser;
use VOCS\PlatformBundle\Form\ListsType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use VOCS\PlatformBundle\Form\WordTradType;

class ListsController extends Controller
{

    /**
     *  @ApiDoc(
     *     section="Lists",
     *  description="Récupère toutes les listes",
     *  output= { "class"=Lists::class, "collection"=true,  "groups"={"list"} }
     *  )
     *
     * @Rest\View(serializerGroups={"list"})
     * @Rest\Get("/rest/lists")
     */
    public function getListsAction(Request $request)
    {
        $lists = $this->getDoctrine()->getRepository(Lists::class)->findAll();

        return $lists;
    }

    /**
     *  @ApiDoc(
     *     section="Lists",
     *  description="Récupère une liste",
     *  output= { "class"=Lists::class, "collection"=false, "groups"={"list"} }
     *  )
     *
     * @Rest\View(serializerGroups={"list"})
     * @Rest\Get("/rest/lists/{id}")
     */
    public function getListAction(Request $request)
    {
        $list = $this->getDoctrine()->getRepository(Lists::class)->find($request->get('id'));
        return $list;
    }



    /**
     * POST
     */

    /**
     * @ApiDoc(
     *     section="Lists",
     *    description="Crée une liste",
     *    input={"class"=ListsType::class, "name"=""}
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"list"})
     * @Rest\Post("/rest/lists")
     */
    public function postListsAction(Request $request)
    {
        $list = new Lists();

        $form = $this->createForm(ListsType::class, $list);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->persist($list);
            $em->flush();

            return $list;
        } else {
            return $form;
        }

    }


    /**
     * @ApiDoc(
     *     section="Lists",
     *    description="Crée des mots dans une liste",
     *    input={"class"=WordTradType::class, "name"="", "groups"={"list"} }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"list"})
     * @Rest\Post("/rest/lists/{id}/wordTrad")
     */
    public function postListsWordTradAction(Request $request) {

        $list = $this->getDoctrine()->getRepository(Lists::class)->find($request->get('id'));
        $wordTrad = new WordTrad();

        $form = $this->createForm(WordTradType::class, $wordTrad);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $repWord = $em->getRepository(Words::class);
            $word = $repWord->findBy(array('content' => $wordTrad->getWord()->getContent(), 'language' => $wordTrad->getWord()->getLanguage()));
            if($word != null) {
                $wordTrad->setWord($word);
            }else {
                $word = $wordTrad->getWord();
            }
            $trad = $repWord->findBy(array('content' => $wordTrad->getTrad()->getContent(), 'language' => $wordTrad->getTrad()->getLanguage()));
            if($trad != null) {
                $wordTrad->setTrad($trad);
            } else {
                $trad = $wordTrad->getTrad();
            }

            $list->addWordTrad($wordTrad);
            $em->persist($wordTrad);
            $em->flush();
            $view = View::create($list);


        } else {
            $view = View::create($form);
        }

        return $view->setHeader('Access-Control-Allow-Origin', '*');

    }

    /**
     * PUT
     */

    /**
     * @ApiDoc(
     *     section="Lists",
     *    description="Change une liste",
     *    input={"class"=ListsType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"list"})
     * @Rest\Put("/rest/lists/{id}")
     */
    public function putListsAction(Request $request)
    {
        return $this->updateList($request, true);
    }

    /**
     * @ApiDoc(
     *     section="Lists",
     *    description="Patch une liste",
     *    input={"class"=ListsType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"list"})
     * @Rest\Patch("/rest/lists/{id}")
     */
    public function patchListsAction(Request $request)
    {
        return $this->updateList($request, false);
    }


    private function updateList(Request $request, $clearMissing) {
        $list = $this->getDoctrine()->getRepository(Lists::class)->find($request->get('id'));

        if (empty($list)) {
            return new JsonResponse(['message' => 'List not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ListsType::class, $list);

        $form->submit($request->request->all(), $clearMissing);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->merge($list);
            $em->flush();

            return View::create($list)->setHeader('Access-Control-Allow-Origin', '*');
        } else {
            return View::create($form)->setHeader('Access-Control-Allow-Origin', '*');
        }
    }

    /**
     * @ApiDoc(
     *     section="Lists",
     *     description="Remove une liste",
     *     output= { "class"=Liste::class, "collection"=false, "groups"={"list"} }
     *     )
     *
     * @Rest\View(serializerGroups={"list"})
     * @Rest\Delete("/rest/lists/{id}")
     */
    public function deleteList(Request $request) {
        $list = $this->getDoctrine()->getRepository(Lists::class)->find($request->get('id'));

        $em = $this->getDoctrine()->getManager();

        $em->remove($list);
        $em->flush();

        return View::create($list)->setHeader('Access-Control-Allow-Origin', '*');
    }

    /**
     * @ApiDoc(
     *     section="Lists",
     *     description="Remove un wordTrad d'une liste",
     *     output= { "class"=WordTrad::class, "collection"=false, "groups"={"wordTrad"} }
     *     )
     *
     * @Rest\View(serializerGroups={"wordTrad"})
     * @Rest\Delete("/rest/lists/{id}/wordTrad/{wordTrad_id}")
     */
    public function deleteListWordTrad(Request $request) {
        $list = $this->getDoctrine()->getRepository(Lists::class)->find($request->get('id'));
        $wordTrad = $this->getDoctrine()->getRepository(WordTrad::class)->find($request->get('wordTrad_id'));

        if($list->getWordTrads()->contains($wordTrad)) {
            $em = $this->getDoctrine()->getManager();
            $list->removeWordTrad($wordTrad);

            $wtus = $this->getDoctrine()->getRepository(WordTradUser::class)->findBy(array('wordTrad' => $wordTrad->getId()));

            foreach ($wtus as $wtu) {
                $em->remove($wtu);
            }

            $em->remove($wordTrad);
            $em->flush();

            return $wordTrad;
        }else {
            $response = [
                "code" => 404,
                "message" => "La liste " . $list->getId() . " ne contient le wordTrad " . $wordTrad->getId(),
            ];
            return $response;
        }


    }


}