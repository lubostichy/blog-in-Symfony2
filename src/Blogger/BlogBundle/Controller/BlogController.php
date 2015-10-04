<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Kontrolér pre článok.
 * @package Blogger\BlogBundle\Controller
 */
class BlogController extends Controller
{
        /**
         * Zobrazí článok s jeho komentármi.
         * @param int $id identifikátor článku
         * @return Response renderovanie článku s jeho komentármi
         * @throws NotFoundHttpException neexistujúca stránka
         */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

		if(!$blog)
		{
			throw $this->createNotFoundException('Unable to find Blog post.');
		}

		$comments = $em->getRepository('BloggerBlogBundle:Comment')
                   ->getCommentsForBlog($blog->getId());


		return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
			'blog'=> $blog,
			'comments' => $comments
			));
	}
}