<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
    * @Route("/create")
    */
    public function createAction()
    {
        $post = new Post();
        $post->setName('Keybo');
	
	$post->setItemTimestamp(new \DateTime("now"));

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($post);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id '.$post->getId());
    }
    
    /**
    * @Route("/show")
    */
    public function showAction()
    {
	$posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();

	$return = '';
	foreach($posts as $post) {
		$return .= $post->getName(). ' '.$post->getItemTimestamp()->format('Y-m-d')."\n";
	}
        return new Response('Saved new product with id '.$return);
    }
}
