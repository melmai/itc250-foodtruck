<?php
//extras.php

$myExtra = new Extra(0,"Ex. Cheese","Extra slice of cheese", .55);
$config->extras[] = $myExtra;

$myExtra = new Extra(1,"Pickles","Crisp slices of garlic dill pickle", .25);
$config->extras[] = $myExtra;

$myExtra = new Extra(2,"Onions","Diced Sweet Onions", .35);
$config->extras[] = $myExtra;

$myExtra = new Extra(3,"Tomatoes","Slices of fresh Greenhouse Tomatoes", .25);
$config->extras[] = $myExtra;

$myExtra = new Extra(4,"Mushrooms","Sauted Portobella Mushrooms", .55);
$config->extras[] = $myExtra;

$myExtra = new Extra(5,"Red Peppers","Mama Lil's Pickeled Peppers!", .75);
$config->extras[] = $myExtra;

$myExtra = new Extra(6,"Ex. Pineappple","Extra slice of sweet Pineapple", .55);
$config->extras[] = $myExtra;

$myExtra = new Extra(7,"Ex. Jalepenos","Extra smoked Jalepeno peppers", .25);
$config->extras[] = $myExtra;

$myExtra = new Extra(8,"Ex. Canadian Bacon","Extra slice maple cured Canadian Bacon", .85);
$config->extras[] = $myExtra;

$myExtra = new Extra(9,"Bacon","Thick slices of apple cured Bacon", 1.50);
$config->extras[] = $myExtra;

$myExtra = new Extra(10,"Avocado","Fresh ripe, California Avocado", 1.00);
$config->extras[] = $myExtra;

$myExtra = new Extra(11,"Ex. Squash","Extra portion delicious candied squash", 1.40);
$config->extras[] = $myExtra;

$myExtra = new Extra(12,"Ex. Cilantro","Additional spicey cilantro goodness", 1.85);
$config->extras[] = $myExtra;

class Extra
{
    public $ID = 0;
    public $Name = '';
    public $Price = 0;
    public $Description = '';

    public function __construct($ID,$Name,$Description,$Price)
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;

    }#end Extra constructor
    
    public function getExtra($ID)
    {
        return $config->extras[$ID];    
    }

}#end Extra class
