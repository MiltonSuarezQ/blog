<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PostController extends AbstractController
{
    /**
     * @Route("/new-post", name="NewPost")
     */
    public function index(Request $request,SluggerInterface $slugger)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $brochureFile = $form['image']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Archivo no se pudo subir');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setImage($newFilename);
            }

            $user = $this->getUser();
            $post->setUser($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('post/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Posts/{id}", name="VerPosts")
     */
    public function VerPost($id){
        $em = $this->getDoctrine()->getManager();
        $user =$this->getUser();
        $post = $em->getRepository(Post::class)->find($id);
        $posts = $em->getRepository(Post::class)->findAll();
        return $this->render('post/verPost.html.twig', [
            'post'=>$post,
            'posts'=>$posts
        ]);
    }

    /**
     * @Route("/list-post", name="ListPosts")
     */
    public function listPost(){
        $em = $this->getDoctrine()->getManager();
        $user =$this->getUser();
        $posts = $em->getRepository(Post::class)->findBy(['user'=>$user]);
        return $this->render('post/list-posts.html.twig',[
            'posts'=>$posts
        ]);
    }
}
