<?php
namespace VOCS\PlatformBundle\Controller\API;


use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use VOCS\PlatformBundle\Entity\Classes;
use VOCS\PlatformBundle\Entity\Lists;
use VOCS\PlatformBundle\Entity\User;
use VOCS\PlatformBundle\Entity\WordTradUser;
use VOCS\PlatformBundle\Form\ClassesType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class ClassesController extends Controller
{

    /**
     * GET
     */

    /**
     *  @ApiDoc(
     *     section="Classes",
     *     description="Récupère toutes les classes",
     *     output= { "class"=Classes::class, "collection"=true, "groups"={"classes"} }
     *     )
     *
     * @Rest\View(serializerGroups={"classes"})
     * @Rest\Get("/rest/classes")
     */
    public function getClassesAction(Request $request)
    {
        $classes = $this->getDoctrine()->getRepository(Classes::class)->findAll();

        $view = View::create($classes);
        $view->setHeader('Access-Control-Allow-Origin', '*');

        return $view;
    }


    /**
     * @ApiDoc(
     *     section="Classes",
     *     description="Récupère une classe",
     *     output= { "class"=Classes::class, "collection"=false, "groups"={"classe"} }
     *     )
     *
     * @Rest\View(serializerGroups={"classe"})
     * @Rest\Get("/rest/classes/{id}")
     */
    public function getClasseAction(Request $request)
    {
        $classe = $this->getDoctrine()->getRepository(Classes::class)->find($request->get('id'));

        $view = View::create($classe);
        $view->setHeader('Access-Control-Allow-Origin', '*');

        return $view;
    }

    /**
     * @ApiDoc(
     *     section="Classes",
     *     description="Récupère les listes d'une classe",
     *     output= { "class"=Classes::class, "collection"=true, "groups"={"list"} }
     *     )
     *
     * @Rest\View(serializerGroups={"list"})
     * @Rest\Get("/rest/classes/{id}/lists")
     */
    public function getClasseListsAction(Request $request)
    {
        $classe = $this->getDoctrine()->getRepository(Classes::class)->find($request->get('id'));
        $lists = $classe->getLists();

        foreach ($lists as $list) {
            foreach ($list->getWordTrads() as $wordTrad) {
                $wordTradUser = $this->getDoctrine()->getRepository(WordTradUser::class)->findOneBy(array('user' => $request->get('id'), 'wordTrad' => $wordTrad->getId()));
                $wordTrad->setStat($wordTradUser);
            }
        }

        return $lists;
    }

 /**
     * @ApiDoc(
  *         section="Classes",
     *     description="Récupère une liste d'une classe",
     *     output= { "class"=Classes::class, "collection"=false, "groups"={"list"} }
     *     )
     *
     * @Rest\View(serializerGroups={"list"})
     * @Rest\Get("/rest/classes/{id}/lists/{list_id}")
     */
    public function getClasseListAction(Request $request)
    {
        $classe = $this->getDoctrine()->getRepository(Classes::class)->find($request->get('id'));
        $list = $this->getDoctrine()->getRepository(Lists::class)->find($request->get('list_id'));

        foreach ($list->getWordTrads() as $wordTrad) {
            $wordTradUser = $this->getDoctrine()->getRepository(WordTradUser::class)->findOneBy(array('user' => $request->get('id'), 'wordTrad' => $wordTrad->getId()));
            $wordTrad->setStat($wordTradUser);
        }

        if($classe->getLists()->contains($list)) {
            $view = View::create($list);
        } else {
            $response = [
                "code" => 404,
                "message" => "la classe " . $classe->getId() . " ne contient pas la liste " . $list->getId(),
            ];
            $view = View::create($response)->setStatusCode(404);
        }

        $view->setHeader('Access-Control-Allow-Origin', '*');

        return $view;
    }



    /**
     * POST
     */

    /**
     *  @ApiDoc(
     *     section="Classes",
     *    description="Crée une classe",
     *    input={"class"=ClassesType::class, "name"="", "groups"={"classe"}}
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"classe"})
     * @Rest\Post("/rest/classes")
     *
     */
    public function postClasseAction(Request $request) {
        $classe = new Classes();

        $form = $this->createForm(ClassesType::class, $classe);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classe);
            $em->flush();
            return $classe;

        } else {
            return $form;

        }

    }

    /**
     * PUT
     */

    /**
     * @ApiDoc(
     *     section="Classes",
     *    description="Change une classe",
     *    input={"class"=ClassesType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"classe"})
     * @Rest\Put("/rest/classes/{id}")
     */
    public function putClassesAction(Request $request)
    {
        return $this->updateClasse($request, true);
    }

    /**
     * @ApiDoc(
     *     section="Classes",
     *    description="Patch une classe",
     *    input={"class"=ClassesType::class, "name"=""}
     * )
     *
     * @Rest\View(serializerGroups={"classe"})
     * @Rest\Patch("/rest/classes/{id}")
     */
    public function patchClassesAction(Request $request)
    {
        return $this->updateClasse($request, false);
    }


    private function updateClasse(Request $request, $clearMissing) {
        $classe = $this->getDoctrine()->getRepository(Classes::class)->find($request->get('id'));


        $form = $this->createForm(ClassesType::class, $classe);

        $form->submit($request->request->all(), $clearMissing);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $classe;
        } else {
            return $form;
        }
    }

    /**
     * DELETE
     */


    /**
     * @ApiDoc(
     *     section="Classes",
     *     description="Remove une classe",
     *     output= { "class"=Classes::class, "collection"=false, "groups"={"classe"} }
     *     )
     *
     * @Rest\View(serializerGroups={"classe"})
     * @Rest\Delete("/rest/classes/{id}")
     */
    public function deleteClasse(Request $request) {

        $classe = $this->getDoctrine()->getRepository(Classes::class)->find($request->get('id'));

        $em = $this->getDoctrine()->getManager();

        $em->remove($classe);
        $em->flush();

        return $classe;
    }
    
    
    /**
     * @ApiDoc(
     *     section="Classes",
     *     description="Remove un user d'une classe",
     *     output= { "class"=Classes::class, "collection"=false, "groups"={"classe"} }
     *     )
     *
     * @Rest\View(serializerGroups={"classe"})
     * @Rest\Delete("/rest/classes/{id}/users/{user_id}")
     */
    public function deleteUserClasse(Request $request) {

        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('user_id'));
        $classe = $this->getDoctrine()->getRepository(Classes::class)->find($request->get('id'));

        $user->removeClass($classe);
        $classe->removeUser($user);

        $this->getDoctrine()->getManager()->flush();

        $view = View::create($classe);
        $view->setHeader('Access-Control-Allow-Origin', '*');

        return $view;
    }
}