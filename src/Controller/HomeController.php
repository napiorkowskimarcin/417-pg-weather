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
      * @Route("/")
      */
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            'http://api.gios.gov.pl/pjp-api/rest/station/findAll'
        );
        
        $content = $response->toArray();
        array_multisort(array_map(function($element) {
        return $element['city']['name'];
        }, $content), SORT_ASC, $content);
        
        foreach ($content as &$element) {
        array_splice($element, 2, 2);
        }
        foreach ($content as &$element) {
        array_splice($element, 3, 1);
        }
        
        // return $this->json($content);
        return $this->render('home.html.twig', ['content'=>json_encode($content)]);
    }
    
}