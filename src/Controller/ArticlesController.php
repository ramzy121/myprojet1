<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;

class ArticlesController extends AbstractController
{

/**
 * @Route("/article/add", name="article_add")
 */
public function addArticle(EntityManagerInterface $entityManger):Response
{
    $article = new Article();
    $article->getId();
    $article->setDesignation("the breakfast");
    $article->setDescription("the breakfast burrito on my plate");
    $article->setPrix(5000);
    $entityManger->persist($article);

    $entityManger->flush();
    return $this->render('articles/index.html.twig', [
        'article'=>$article ,
        
    ]);

}


   /**
     * @Route("/article/{id}", name="article_routes")
     */
    public function showArticle(int $id,ArticleRepository $ArticleRepository):Response
    {
        $article=$ArticleRepository->find($id);
        if(!$id)
        {
            throw $this->createNotFoundException("id incorrect");

        }
        return $this->render('articles/show.html.twig',[
            'article'=>$article,]);

    }


    /**
     * @Route("/articles", name="articles_routes")
     */
    public function showArticles(ArticleRepository $ArticleRepository ): Response
    {

        $articles=$ArticleRepository->findAll();
        if(!$articles){
        
            throw $this->createNotFoundException("aucun articles trouvés");
        }
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    
    /**
     * @Route("/home/{name?}/{age?}", name="home")
     */
    public function index1($name,$age): Response
    {
        
        return $this->render('shared/home.html.twig', [
            'name' => $name,
            'age' => $age
        ]);
    }





    

       /**
     * @Route("/article/{id}", name="article_routes")
     */
    public function showArticle(ArticleRepository $ArticleRepository ):Response
    {
        $article=$ArticleRepository->find($id);
        if(!$id)
        {
            throw $this->createNotFoundException("incorrect");

        }
        return $this->render('articles/show.html.twig',[
            'article'=>$article,]);

    }


     /**
     * @Route("/art/edit/{id}",priority=3, name="article_udate")
     */

    public function editArticle(Article $article,EntityManagerInterface $entityManager):Response
    {
     if(!$article)
      {
        return $this->createNotFoundException("Aucun Article Correspand a cette ID");
      }
     $article->SetPrix(22);
     #permer d'executer la requete et d'envoyer a la BD tout ce qui a été persisté dans entity manager
     $entityManager->flush();
     return $this->redirectToRoute('articles_routes');


}


}
