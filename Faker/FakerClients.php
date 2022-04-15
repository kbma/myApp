<?php
//https://fakerphp.github.io/
require_once '../vendor/autoload.php';
include '../inc/DB.php';


class FakerClient extends DB
{

    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    public function generator(){
        $Faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {

            $TITRE=$Faker->title();
            $NOM=$this->clean(htmlspecialchars($Faker->firstName()));
            $PRENOM=$this->clean(htmlspecialchars($Faker->lastName()));
            $TEL=$Faker->phoneNumber();
            $PHOTO="images/inconnu.jpg";
            // usleep(2000000);

            echo $sql="INSERT INTO `clients`(`NOM`, `PRENOM`, `TEL`, `PHOTO`) VALUES ('$NOM','$PRENOM','$TEL','$PHOTO')";

           $action =$this->cnx->query($sql);

        }
    }

}
$f = new FakerClient();
$f->generator();