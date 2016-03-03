<?php
/**
 * Created by Virgil
 * Date: 3/1/2016
 * Time: 7:00 AM
 */

namespace AppBundle\Controller\Api;


use AppBundle\Controller\BaseController;
use AppBundle\Entity\Programmer;
use AppBundle\Form\ProgrammerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgammerController extends BaseController
{
    /**
     * @Route("/api/programmers")
     * @Method("POST")
     */
    public function newAction (Request $request)
    {
        $body = $request->getContent($request);

        // create a programmer
        $data = json_decode($body, true);

        $programmer = new Programmer();
        $form = $this->createForm(new ProgrammerType(), $programmer);
        $form->submit($data);
        $programmer->setUser($this->findUserByUsername('weaverryan'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($programmer);
        $em->flush();

        $programmersUrl = $this->generateUrl('api_programmers_show',[
            'nickname' => $programmer->getNickname()
        ]);

        $data = $this->serializeProgrammers($programmer);

        $response = new JsonResponse($data, 201);
        $response->headers->set('Location',$programmersUrl);

        return $response;
    }

    /**
     * @Route("/api/programmers/{nickname}", name="api_programmers_show")
     * @Method("GET")
     */
    public function showAction($nickname)
    {
        $programmer = $this->getDoctrine()->getRepository('AppBundle:Programmer')->findOneByNickname($nickname);

        if (!$programmer){
            throw $this->createNotFoundException(sprintf(
               'No programmer found with this nickname "%s"',
                $nickname
            ));
        }

        $data = $this->serializeProgrammers($programmer);

        $response = new JsonResponse($data, 200);

        return $response;
    }

    /**
     * @Route("/api/programmers")
     * @Method("GET")
     */
    public function listAction ()
    {
        $programmers = $this->getDoctrine()->getRepository('AppBundle:Programmer')->findAll();

        $data = array("programmers" => array());

        foreach ($programmers as $programmer) {
            $data['programmers'][] = $this->serializeProgrammers($programmer);
        }

        $response = new JsonResponse($data, 200);

        return $response;

    }

    /**
     * Return a programmer object into an array
     * @param Programmer $programmer
     * @return array
     */
    private function serializeProgrammers (Programmer $programmer)
    {
        return array(
            'nickname' => $programmer->getNickname(),
            'avatarNumber' => $programmer->getAvatarNumber(),
            'powerLevel' => $programmer->getPowerLevel(),
            'tagLine' => $programmer->getTagLine(),
        );
    }
}