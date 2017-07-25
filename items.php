<?php
/** items.php
 *
 * @package ITC250
 * @author Melissa Wong <mellymai@gmail.com>
 * @link http://mel.codes/
 * @author Jeanine Mars <jeaninemars1@gmail.com>
 * @author Ron Nims <rleenims@gmail.com>
 * @link http://www.artdevsign.com/
 * @version 0.1 2017/07/22
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @todo none
 */

include 'extras.php';
global $config;

$myItem = new Item(0,"Classic Cheese Burger",
                   "¤ The original, a simple classic cheese burger.<br/>" .
                   "One quarter pound all beef burger, thick slice " .
                   "cheddar cheese, lettuce, ketchup and mustard.",
                   4.95);
$myItem->addExtra(0); //extra cheese
$myItem->addExtra(1); //pickles
$myItem->addExtra(2); //onions
$myItem->addExtra(3); //tomatoes
$myItem->addExtra(4); //mushrooms
$config->items[] = $myItem;

$myItem = new Item(1,"Flying Hawaiin Burger",
                   "¤ Sunny, savory tropical burger delight!<br/>" .
                   "One quarter pound all beef burger, swiss cheese, " .
                   "thick Canadian bacon, pineapple, lettuce, special sauce.",
                   5.95);
$myItem->addExtra(0); //extra cheese
$myItem->addExtra(6); //extra pineapple
$myItem->addExtra(8); //extra bacon
$myItem->addExtra(5); //Mama Lils peppers
$config->items[] = $myItem;

$myItem = new Item(2,"Flaming Salsa Burger",
                   "¤ Careful, this is one hot-n-spicey burger!<br/>" .
                   "One quarter pound all beef burger, pepper jack cheese, " .
                   "sliced smoked jalepenos, fresh house salsa, lettuce",
                   6.45);
$myItem->addExtra(0); //extra cheese
$myItem->addExtra(2); //onions
$myItem->addExtra(7); //extra jalepenos
$myItem->addExtra(5); //Mama Lils peppers
$config->items[] = $myItem;

$myItem = new Item(3,"Poutine on the Ritz Burger",
                   "¤ Topped with poutine and side of Ritz crackers",
                   11.25);
$myItem->addExtra(9); //bacon
$myItem->addExtra(2); //onions
$myItem->addExtra(10); //avocado
$config->items[] = $myItem;

$myItem = new Item(4,"Gourdon Hamsey Burger",
                   "¤ Comes with squash and ham",
                   9.95);
$myItem->addExtra(11); //extra squash
$myItem->addExtra(0); //extra cheese
$myItem->addExtra(9); //bacon
$myItem->addExtra(2); //onions
$config->items[] = $myItem;

$myItem = new Item(5,"Say It Ain't Cilantro Burger",
                   "¤ Comes with cilantro",
                   8.50);
$myItem->addExtra(12); //extra cilantro
$myItem->addExtra(0); //extra cheese
$myItem->addExtra(4); //mushrooms
$myItem->addExtra(10); //avocado
$config->items[] = $myItem;

/* DEBUG
echo '<pre>';
var_dump($config);
echo '</pre>';
die;
*/


class Item
{
    public $ID = 0;
    public $Name = '';
    public $Price = 0;
    public $Description = '';
    public $Extras = array();
    
    public function __construct($ID,$Name,$Description,$Price)
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        
    }#end Item constructor
    
    public function addExtra($extra)
    {
        $this->Extras[] = $extra;
        
    }#end addExtra()
    
    public static function getItem($ID)
    {
        return $config->items[$ID];    
    }

}#end Item class











