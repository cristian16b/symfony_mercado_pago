<?php
namespace App\Controller;

use MercadoPago;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function index()
    {
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken('');

// Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = 'Mi producto';
        $item->description = 'Descripción de Mi producto';
        $item->quantity = 1;
        $item->unit_price = 75;
        $preference->items = array($item);   
        $preference->save();

        return $this->render('index.html.twig');
    }
}
