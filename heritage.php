<?php
class GrandPa
{
    protected $name='Mark Henry';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
class Daddy extends GrandPa // Inherited class
{
  function displayGrandPaName()
     {
         return $this->name;
    }
}

//Test
$GP = new GrandPa;
echo $GP->getName();

echo "<br>";
$daddy = new Daddy;
echo $daddy->displayGrandPaName();



