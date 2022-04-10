<?php
//https://fakerphp.github.io/
require_once '../vendor/autoload.php';
include '../inc/DB.php';


class FakerProduit
{
    public $c;

    public function __construct()
    {
        $mysql= new DB();
        $this->c= $mysql->cnx;
    }
    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    public function generator(){
        $Faker = Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $LIBELLE=$this->clean(htmlspecialchars($Faker->realText(10)));
            $PRIX=$this->clean(htmlspecialchars($Faker->numberBetween(1,500)));
            $PHOTO="images/produit.jpg";
            // usleep(2000000);

            echo $sql="INSERT INTO `produits`(`LIBELLE`, `PRIX`, `PHOTO`) VALUES ('$LIBELLE','$PRIX','$PHOTO')";
           $action =$this->c->query($sql);

        }
    }

}
$f = new FakerProduit();
$f->generator();