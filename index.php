<?php
/**
 *
 * @package ITC250
 * @author Melissa Wong <mellymai@gmail.com>
 * @link http://mel.codes/
 * @author Ron Nims <rleenims@gmail.com>
 * @link http://www.artdevsign.com/
 * @version 0.1 2017/07/22
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @todo none
 */

include 'items.php'; 

define('THIS_PAGE', basename($_SERVER['PHP_SELF']));
define("SALESTAX", 0.1);
$subtotal = 0;

include 'header.php';

if(isset($_POST["Submit"])) {
    showData($config->items, $config->extras);
} else {
    showForm($config->items, $config->extras);
}

include 'footer.php';

/* function writeItem
 * echo  html table row for one order item
 * @param object $item - item to write
 * @param int $itemQty - quantity of this item
 * @param float $extrasAmt - total of extras prices 
 * @param string $itemExtras - csv list of extras
 */
function writeItem($item, $itemQty, $extrasAmt, $itemExtras) {
    // trim trailing comma on extras list if exists
    $itemExtras = trim($itemExtras);
    if ($itemExtras[strlen($itemExtras) - 1] == ',' ) {
        $itemExtras = substr($itemExtras, 0, strlen($itemExtras) - 1);
    }
    
    if ($itemQty > 0) {
        $itemTotal = ($item->Price + $extrasAmt) * $itemQty;

        echo '<tr><td class="center"><b>' . $itemQty . '</b></td>';
        echo '<td><b>' . $item->Name;
        if ($itemQty > 1) {
            echo 's';
        }
        echo '</b><br/>';
        if (strlen($itemExtras) > 0) {
            echo 'With: ' . $itemExtras . '</td>';
        }else{
            echo 'Straight up!</td>';
        }
        echo '<td class="right">$' . sprintf("%01.2f", $itemTotal) . '</td></tr>';

        return $itemTotal;
    }else{
        return 0;
    }
}

/* function showForm
 * write the menu order form page
 * @param array $items
 * @param array $extras
 */
function showForm($items, $extras)
{# shows form for order entry
	
	echo '        <div id="logo">
            <img src="logo.png">
            <h1>Order Form</h1>
        </div>
        <form action="" method="post">';
  
        // Process menu items for form
		foreach($items as $item) {
            // write main item input info
            echo '<div class="item"><p class="item"><b>Qty <input type="number" min="0" max="99" maxlength="2" value="0" name="item_' . $item->ID . '" /> ' . $item->Name . ' ~ $' . sprintf("%01.2f",$item->Price) . ' </b></p>';
            echo '<p>' . $item->Description . '</p>';
            
            // write related extras input info
            echo '<section class="extra-flex">';
            foreach($item->Extras as $extraID) {
                echo '<div class="extra-item" title="' . $extras[$extraID]->Description .
                    '"><label><input type="checkbox" name="item_' . $item->ID . '_' .
                $extraID . '" > ' . $extras[$extraID]->Name . ' <b>+ $' .
                sprintf("%01.2f",$extras[$extraID]->Price) . '</b></label></div>';     
            }
            echo '</section>';

            echo '</div>';
        }       
        
        echo '<input type="submit" name="Submit" value="Place Order"/>
            </form>
            ';
}

/* function showData
 * write the receipt page
 * order information passed in $_POST
 * @param array $extras
 */
function showData($items, $extras)
{#form submits here we show entered name
	global $subtotal;
    // Process menu items for form
    
    //DEBUG echo '<pre>';
    //DEBUG var_dump($_POST);
    //DEBUG echo '</pre>';
    //DEBUG die;
    
    // get_header(); #defaults to footer_inc.php
        
    //table header
    echo '        <table>
        <thead>
            <tr>
                <th>Qty</td>
                <th>Items</td>
                <th>Price</td>
            </tr>
        </thead>
        <tbody>';

    $itemQty = $value;
    $itemExtras = "";
    $extrasTotal = 0;

    // set currentItem high so first pass doesnt write anything
    $currentItem = 1000;
    
	foreach($_POST as $name => $value) {
        //loop the form elements
         
        //if form name attribute starts with 'item_', process it
        if(substr($name,0,5)=='item_') {
            
            //explode the string into an array on the "_"
            $name_array = explode('_',$name);
            
            //forcibly cast to an int in the process
            $id = (int)$name_array[1];

            if ($id > $currentItem) {
                //new item so write data for currentItem
                $subtotal += writeItem($items[$currentItem], $itemQty, $extrasTotal, $itemExtras);
             }
            
            // if item is not extra
            if ( count($name_array) < 3) {
                //initialize new currentItem info
                $currentItem = $id;
                $itemQty = intval($value);
                $itemExtras = "";
                $extrasTotal = 0.0;
            } else {
            // item is extra
                $extraID = (int)$name_array[2];
                $itemExtras .= $extras[$extraID]->Name . ', ';
                $extrasTotal += $extras[$extraID]->Price;
            };
        }
    }

    // write last item
    $subtotal += writeItem($items[$currentItem], $itemQty, $extrasTotal, $itemExtras);
    
    // write totals & tax
    echo '<tr><td></td><td class="right">Subtotal<br/>Sales Tax<br/><b>Order Total</b></td><td class="right">$' . 
        sprintf("%01.2f", $subtotal) . '<br/>$' . sprintf("%01.2f", $subtotal * SALESTAX) . '<br/><b>$' . 
        sprintf("%01.2f", $subtotal + ($subtotal * SALESTAX)) . '</b></td></tr>';

    // write link back to form
    echo '<tr><td></td><td class="center">';
    if($subtotal > 0) { //show confirmation if values submitted
        $returnText = 'Place another Order';
    }else{
        $returnText = 'Please Try Again!';
    }
    echo '<a href="'. THIS_PAGE . '"><button type="button">'. $returnText . '</button></a>';       
    
    echo '</td><td></td></tr>';
    
    //table footer
    echo '            </tbody>
        </table>
        ';
    
    if($subtotal > 0) { //show confirmation if values submitted
        echo '<img src="confirm.svg" id="feedback">';
    } else { //show error msg if no values submitted
        echo '<img src="error.svg" id="feedback">';
    }
    echo '<div>
        <img src="logo.png">
    </div>';
}
?>