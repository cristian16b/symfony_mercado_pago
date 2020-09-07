<?php
namespace App\Controller;

use MercadoPago;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function index()
    {
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken('TEST-6864113784926029-082523-64405d2ff4a697e4df1bedc147234d55-167188015');

// Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = 'Mi producto';
        $item->description = 'Descripción de Mi producto';
        $item->quantity = 1;
        $item->unit_price = 75.8;
        $preference->items = array($item);   
        $preference->save();

        // dump($preference->init_point);die;

        return $this->render(
            'index.html.twig',array(
                'url' => $preference->init_point
            )
        );
    }
    // nota para descaegar los usuarios correr el siguiente comando en el cmd de windows
    // curl -X POST -H "Content-Type: application/json" "https://api.mercadopago.com/users/test_user?access_token=TEST-6864113784926029-082523-64405d2ff4a697e4df1bedc147234d55-167188015" -d "{'site_id':'MLA'}"

    // si da error de 0x80092013, correrlo como sigue
    // curl -X POST -H "Content-Type: application/json" "https://api.mercadopago.com/users/test_user?access_token=TEST-6864113784926029-082523-64405d2ff4a697e4df1bedc147234d55-167188015" -d "{'site_id':'MLA'}" --ssl-no-revoke

    // usuarios de prueba creados
    // {"id":639810402,"nickname":"TEST6LKXIIVN","password":"qatest1603","site_status":"active","email":"test_user_11815040@testuser.com"}
    // {"id":639809221,"nickname":"TEST2A0RSAII","password":"qatest4330","site_status":"active","email":"test_user_44600499@testuser.com"}
}