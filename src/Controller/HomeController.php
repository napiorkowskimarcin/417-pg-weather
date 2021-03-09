<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        return $this->render('home.html.twig', ['content'=>json_encode($content), 'stationInfo'=> '']);

         
    }
    /**
      * @Route("/getone/{id}")
      */
    public function getone($id): Response 
    {
        $id = strval($id) ;
        $path = 'http://api.gios.gov.pl/pjp-api/rest/aqindex/getIndex/'.$id;

        $response = $this->client->request(
            'GET',
            $path,
        );
        $content = $response->toArray();

        $template = $this->render('home/_data_loop.html.twig', [
            'stationInfo' => $content,
            ])->getContent(); 
        $response = new JsonResponse();
        $response->setStatusCode(200);
        
        return $response->setData(['template' => $template ]); 
    }
    
}