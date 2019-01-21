<?php

namespace App\Controller;

use App\Repository\MicroPostRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\MicroPost;
use App\Form\MicroPostType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/micro-post")
 */

class MicroPostController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var MicroPostRepository
     */
    private $microPostRepository;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(
        \Twig_Environment $twig, MicroPostRepository $microPostRepository,
        FormFactoryInterface $formFactory
    ) {
        $this->twig = $twig;
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/", name="micro_post_index")
     */
    public function index()
    {
        $html = $this->twig->render('micro-post/index.html.twig', [
            'posts' => $this->microPostRepository->findAll()
        ]);
        return new Response($html);
    }

    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(Request $request)
    {
        // dump($formFactory);
        $microPost = new MicroPost();
        $microPost->setTime(new \DateTime());

        $form = $this->formFactory->create(MicroPostType::class, $microPost);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return new Response(
            $this->twig->render(
                'micro-post/add.html.twig',
                ['form' => $form->createView()]
            )
        );
    }
}