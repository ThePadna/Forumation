<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\SQL\Connection;

class RdmNumber extends Controller {
    /**
     * @Route("/randomnumbah")
     */
    public function gen() {
        $mysql = realpath($this->get('kernel')->getRootDir() . '/../mysql.ini');
        $con = new Connection($mysql);
        $con->connect();
        $num = random_int(0,10000);
        return $this->render("template.html.twig", ['numbah' => $num]);
    }
}
?>