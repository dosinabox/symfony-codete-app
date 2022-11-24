<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(Request $request): JsonResponse
    {
        $name = $request->attributes->get('name');
        $name2 = $request->query->get('name2');

        return $this->json([
            'message' => 'Welcome to your new controller! Name is ' . $name . ', name2 is ' . $name2,
            'path' => 'src/Controller/DefaultController.php',
        ]);
    }
}
