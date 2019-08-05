<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RdmNumber extends AbstractController {
    /**
     * @Route("/randomnumbah")
     */
    public function gen() {
        $num = random_int(0,10000);
        return $this->render("template.html.twig", ['numbah' => $num]);
    }
}
?>