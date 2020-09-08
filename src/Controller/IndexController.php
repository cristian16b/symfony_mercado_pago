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
        MercadoPago\SDK::setAccessToken('TEST-998797040263492-090716-a75fdcc3a6017acac150d2ec98b3654b-639810402');

// Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();
        $preference->back_urls = array(
            "success" => "/success",
            "failure" => "/failure",
            "pending" => "/pending"
        );
        // $preference->auto_return = "approved";
        $preference->payment_methods = array(
            "excluded_payment_types" => array(
              array("id" => "ticket")
            ),
            "installments" => 12,
        );

// Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = 'Mi producto';
        $item->description = 'Descripción de Mi producto';
        $item->quantity = 1;
        $item->unit_price = 75.8;
        $item->category_id = "automotive";
        $item->currency_id = "ARS";
        $preference->items = array($item);   
        $preference->save();

        $payer = new MercadoPago\Payer();
        $payer->name = "Charles";
        $payer->surname = "Luevano";
        $payer->email = "charles@hotmail.com";
        $payer->date_created = "2018-06-02T12:58:41.425-04:00";
        $payer->phone = array(
            "area_code" => "",
            "number" => "949 128 866"
        );

        // dump($preference);die;

        return $this->render(
            'index.html.twig',array(
                // 'url' => "https://www.mercadopago.com.ar/checkout/v1/modal/?preference-id=" . $preference->id
                'preferenceId' => $preference->id
            )
        );
    }
    // nota para descaegar los usuarios correr el siguiente comando en el cmd de windows
    // curl -X POST -H "Content-Type: application/json" "https://api.mercadopago.com/users/test_user?access_token=TEST-6864113784926029-082523-64405d2ff4a697e4df1bedc147234d55-167188015" -d "{'site_id':'MLA'}"

    // si da error de 0x80092013, correrlo como sigue
    // curl -X POST -H "Content-Type: application/json" "https://api.mercadopago.com/users/test_user?access_token=TEST-6864113784926029-082523-64405d2ff4a697e4df1bedc147234d55-167188015" -d "{'site_id':'MLA'}" --ssl-no-revoke

    // usuarios de prueba creados
    // VENDEDOR
    // {"id":639810402,"nickname":"TEST6LKXIIVN","password":"qatest1603","site_status":"active","email":"test_user_11815040@testuser.com"} 
    // COMPRADOR
    // {"id":639809221,"nickname":"TEST2A0RSAII","password":"qatest4330","site_status":"active","email":"test_user_44600499@testuser.com"}

    /**
    * @Route("/vincular/vendedor", name="vincular_vendedor")
    */
    public function vincularVendedorAction(Request $request) {
        dump($request->query->get('code'));
        die('en desarollo...');
    }
   
    // NOTA LA SIGUIENTE URL ES  LA QUE SE DEBEN REDIGIRLOS USUARIOS
    // https://auth.mercadopago.com.ar/authorization?client_id=6864113784926029&response_type=code&platform_id=mp&redirect_uri=http://localhost/symfony_mercado_pago/public/index.php/vincular/vendedor
}