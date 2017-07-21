<?php
/**
 * index.php 
 * 
 * @package Bob's Burgers Order Form
 * @author Melissa Wong <mellymai@gmail.com>
 * @version 0.1 2017/07/17
 * @link http://mel.codes/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @todo none
 */

include 'header.php';

define('THIS_PAGE', basename($_SERVER['PHP_SELF']));

if (isset($_POST["Submit"])) { //show data if values set

    //set vars for form data
    $QuantityBurger1 = $_POST['QuantityBurger1'];
    $ExtrasBurger1 = $_POST['ExtrasBurger1'];

    $QuantityBurger2 = $_POST['QuantityBurger2'];
    $ExtrasBurger2 = $_POST['ExtrasBurger2'];

    $QuantityBurger3 = $_POST['QuantityBurger3'];
    $ExtrasBurger3 = $_POST['ExtrasBurger3'];

    //create objects and use loop to add extras if they exist
    if($QuantityBurger1 > 0) {
       $burger = new Item($QuantityBurger1, 'Poutine on the Ritz Burger', '(topped with poutine and side of Ritz crackers)', 10.99);
        if(count($_POST['ExtrasBurger1']) > 0) { 
            foreach($ExtrasBurger1 as $ExtraBurger1) {
                $burger->addExtra($ExtraBurger1);
            }
        }
            $items[] = $burger;
    }

    if($QuantityBurger2 > 0) {
        $burger = new Item($QuantityBurger2, 'Gourdon Hamsey Burger', '(comes with squash and ham)', 10.99);
        if(count($_POST['ExtrasBurger2']) > 0) {
            foreach($ExtrasBurger2 as $ExtraBurger2) {
                $burger->addExtra($ExtraBurger2);
            }
        } 
        $items[] = $burger;
    }
    
    if($QuantityBurger3 > 0) {
        $burger = new Item($QuantityBurger3, 'Say It Ain\'t Cilantro Burger', '(comes with cilantro)', 11.99);
        if(count($_POST['ExtrasBurger3']) > 0) {
            foreach($ExtrasBurger3 as $ExtraBurger3) {
                $burger->addExtra($ExtraBurger3);
            }
        }
        $items[] = $burger;
    }

    //create beginning of table
    echo '
        <table>
            <thead>
                <tr>
                    <th>Qty</td>
                    <th>Items</td>
                    <th>Price</td>
                </tr>
            </thead>
            <tbody>
    ';

    //initialize vars for calculations
    $extrasCount = 0;
    $extrasCost = 0;
    $itemsCost = 0;

    //use loop to create middle section of table
    if(count($items) > 0) {
        foreach($items as $item) {
            //add calculation values
            $extrasCount += count($item->Extras);
            $extrasCost += $item->calcExtras();
            $itemsCost += $item->Price * $item->Quantity;

            echo "
                <tr>
                    <td class='center'>$item->Quantity</td>
                    <td>
                        $item->Name<br />
                        $item->Description<br />
                        Extras: {$item->showExtras()}
                    </td>
                    <td>
                        \${$item->calcItem($item->Quantity, $item->Price)}<br />
                        + {$item->calcExtras()}
                    </td>
                </tr>
            ";
        }       
    } else {
        echo "
                <tr>
                    <td></td>
                    <td class='center'><h2>No Items Ordered!</h2></td>
                    <td></td>
                </tr>
        ";
    }

    //create variables and calculate tax and totals
    $subtotal = number_format(($extrasCost + $itemsCost), 2);
    $tax = number_format(.10100 * $subtotal, 2);
    $total = number_format(($subtotal + $tax), 2);

    //create end of table
    echo "
                <tr>
                    <td></td>
                    <td class='right'>
                        Subtotal <br />
                        Tax <br />
                        Total <br />
                    </td>
                    <td>
                        \$$subtotal <br />
                        + $tax <br />
                        \$$total <br />
                    </td>
                </tr>
            </tbody>
        </table>
    ";

    if($total > 0) { //show confirmation if values submitted
        echo '<img src="confirm.svg" id="feedback">';
    } else { //show error msg if no values submitted
        echo '<img src="error.svg" id="feedback">';
    }

} else { //show form

    echo '
        <div id="logo">
            <img src="logo.png">
            <h1>Order Form</h1>
        </div>

        <form action="' . THIS_PAGE . '" method="post">
            <p class="item"><select name="QuantityBurger1">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
           Poutine on the Ritz Burger</p>
           <p class="desc">(topped with poutine and side of Ritz crackers)</p>
            <label>
                Extras (+$0.25/ea):<br />
                <input type="checkbox" name="ExtrasBurger1[]" value="Bacon" /> Bacon<br />
                <input type="checkbox" name="ExtrasBurger1[]" value="Onions" /> Onions<br />
                <input type="checkbox" name="ExtrasBurger1[]" value="Avocado" /> Avocado<br />
            </label>            

            <p class="item"><select name="QuantityBurger2">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
           Gourdon Hamsey Burger</p>
           <p class="desc">(comes with squash and ham)</p>
            <label>
                Extras (+$0.25/ea):<br />
                <input type="checkbox" name="ExtrasBurger2[]" value="Bacon" /> Bacon<br />
                <input type="checkbox" name="ExtrasBurger2[]" value="Onions" /> Onions<br />
                <input type="checkbox" name="ExtrasBurger2[]" value="Avocado" /> Avocado<br />
            </label>            

            <p class="item"><select name="QuantityBurger3">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
           Say It Ain\'t Cilantro Burger</p>
           <p class="desc">(comes with cilantro)</p>
            <label>
                Extras (+$0.25/ea):<br />
                <input type="checkbox" name="ExtrasBurger3[]" value="Bacon" /> Bacon<br />
                <input type="checkbox" name="ExtrasBurger3[]" value="Onions" /> Onions<br />
                <input type="checkbox" name="ExtrasBurger3[]" value="Avocado" /> Avocado<br />
            </label>            
            <input type="submit" name="Submit" value="ORDER" />
        </form>
    ';
}

class Item
{
    //initialize values
    public $Quantity = 0;
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Extras = array();

    //constructor function
    public function __construct($Quantity, $Name, $Description, $Price)
    {
        $this->Quantity = $Quantity;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
    } //end constructor function

    //add extras function
    public function addExtra($extra)
    {
        $this->Extras[] = $extra;
    } //end add extras function

    //show extras function
    public function showExtras()
    {
        return implode(', ', $this->Extras);
    } //end show extras function

    //calculate cost of extras
    public function calcExtras()
    {
        $extrasCount = count($this->Extras);
        $extrasCost = number_format(($extrasCount * .25), 2);
        return $extrasCost;
    } //end calculate extras function

    //calculate cost of base item
    public function calcItem($countItem, $costItem)
    {
        $itemCost = number_format(($countItem * $costItem), 2);
        return $itemCost;
    } //end calculate base items function
}

include 'footer.php';
