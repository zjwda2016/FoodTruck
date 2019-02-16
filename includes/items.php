<?php
/**
 * items.php
 *
 * These are the three items that can be added to the cart.
 * It includes the item class itself, and the three item objects.
 *
 * @package ITC250
 * @authors Aaron Lewis <aaron.lewis@seattlcentral.edu>, Liyun Cecil <liyuncecil@gmail.com>, Derrick Mou <jtrvsconan@gmail.com>, Derek Hendrick <mooserkay@gmail.com>
 * @version 1.1 2019/2/14
 * @link http://derekheducation.dreamhosters.com/p3/index.php
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 */
// Item(id for item, name, description, price, quantity);
$myItem = new Item(1, 'Taco', 'Our tacos are awesome', 4.95, 10);
// addExtra(id fpr exxtra, extra name, extra price);
$myItem->addExtra(1, 'Sour Cream', 0.5);
$myItem->addExtra(2, 'Cheese', 0.3);
$myItem->addExtra(3, 'Guacamole', 0.6);
$myItem->addExtra(4, 'Salsa', 0.8);
//out go to bag of food items
$items[] = $myItem;

$myItem = new Item(2, 'Hot Dog', 'Our hot dogs are awesome', 5.95, 20);
$myItem->addExtra(1, 'Ketchup', 0.7);
$myItem->addExtra(2, 'Onions', 0.3);
$myItem->addExtra(3, 'Spicy mustard', 0.9);
$myItem->addExtra(4, 'Saurkraut', 0.5);
$items[] = $myItem;

$myItem = new Item(3, 'Sundae', 'Our sundaes are awesome', 3.95, 25);
$myItem->addExtra(1, 'Chocolate', 1.3);
$myItem->addExtra(2, 'Nuts', 2.1);
$myItem->addExtra(3, 'Whipped cream', 3.2);
$myItem->addExtra(4, 'Cherry', 1.7);
$items[] = $myItem;

class Item
{
    //properties
    public $ID = 0;
    public $Name = '';
    public $Description = '';
    public $Price = 0;
  	public $Inventory = 0;
    public $Extras = array(); //presents 1 to many relationships
    
    //constructor
    public function __construct($ID, $Name, $Description, $Price, $Inventory)
    {
        //$this->ID points to the variable $ID
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
      	$this->Inventory = $Inventory;
    }//end constructor
    
    //methods
    public function addExtra($extraId, $extra, $extraMo)
    {    
        $this->ExtrasId[] = $extraId;
      	$this->Extras[] = $extra;
      	$this->ExtrasMo[] = $extraMo;
    }//end function addExtra();
}//end Item class
