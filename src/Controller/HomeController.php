<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
     private $client;

    public function __construct(HttpClientInterface $client) 
    {
        $this->client = $client;
    }
    /**
      * @Route("/home")
      */
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            'http://api.gios.gov.pl/pjp-api/rest/station/findAll'
        );
         $content = $response->getContent();
        $content = $response->toArray();

        return $this->render('home.html.twig', ['content'=>$content]);
    }
}