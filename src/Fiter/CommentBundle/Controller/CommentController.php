<?php

namespace Fiter\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CommentController extends Controller{

    /**
     * Returns a flat array of last comments.
     * @Route("/last", name="fos_comment_last_comments")
     * @Template()
     */
    public function lastCommentsAction(){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM FiterDefaultBundle:Comment p ORDER BY p.createdAt DESC'
        );
        $query->setMaxResults(6);
        $comments = $query->getResult();

        $res = array();

        foreach ($comments as $key => $comment) {
        	$id=\str_replace("type_", "",$comment->getThread()->getId());
        	$articulo = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        	//ladybug_dump($articulo);
        	//ladybug_dump($comment);
        	$res[]= array(
			    "comment" => $comment,
			    "articulo" => $articulo,
			);
        }
        return array(
            'res' => $res
        );
    }



}
