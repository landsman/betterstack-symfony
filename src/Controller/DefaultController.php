<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="demo")
     */
    public function index(LoggerInterface $logger): Response
    {
        $logger->info('Hello to betterstack!');

        return $this->render('index.html.twig');
    }
}