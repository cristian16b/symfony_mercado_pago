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

    // curl -X POST \-H "Content-Type: application/json" \"https://api.mercadopago.com/users/test_user?access_token=TEST-6864113784926029-082523-64405d2ff4a697e4df1bedc147234d55-167188015" \-d '{"site_id":"MLA"}'

    /**
    * @Route("/descargar/usuario", name="descargar_usuario")
    */
    public function descargarCategoriasAction(){
        $url = 'https://api.mercadopago.com/users/test_user?access_token=TEST-6864113784926029-082523-64405d2ff4a697e4df1bedc147234d55-167188015';
        $data = file_get_contents($url);
        file_put_contents('./../usuario.json',$data);
        die;
    }
}
