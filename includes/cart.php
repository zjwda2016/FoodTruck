<?php
/**
 * cart.php
 *
 * This is the cart handler.
 * It takes the data from the index.php and POST, to insert it into the cart.
 * The cart uses cookies to store the items over time, though they will expire in 30 days.
 *
 * @package ITC250
 * @authors Aaron Lewis <aaron.lewis@seattlcentral.edu>, Liyun Cecil <liyuncecil@gmail.com>, Derrick Mou <jtrvsconan@gmail.com>, Derek Hendrick <mooserkay@gmail.com>
 * @version 1.1 2019/2/14
 * @link http://derekheducation.dreamhosters.com/p3/index.php
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 */
//ob_start();
$showMessage = '';
if(isset($_POST['addToCart']))
{
  	//For infomation of order create extra id and assign to $_POST
  	if(isset($_POST['extraNamePrice'])){
      	$itemArray = array(
      		'itemId'				=>	$_POST['id'],
        	'itemExtraNamePrice'	=>	$_POST['extraNamePrice']
    	);
      
      	$cartData[] = $itemArray;
  	// test
  	//echo print_r($itemArray, true);
	foreach($cartData as $keys => $values){	
    	$extraIdToItem = '';
      	$extraId = '';
        foreach($values['itemExtraNamePrice'] as $result) 
        {
        	// test
            //echo '<br>'.print_r($result, true);
                  
           	// Split a string by a string
          	$resultEx = explode(",", $result);
            $extraIdToItem .= $resultEx[0];
        }
        $extraId = $values['itemId'] . $extraIdToItem;
       	$_POST['id'] = $extraId;
    }
  
    }else{
      $itemArray = array(
      	'itemId'				=>	$_POST['id'],
        'itemExtraNamePrice'	=>	null
    	);
      $cartData[] = $itemArray;
    }
  	
	

  	// test
  	//echo '<br>Extra ID: '. $extraId;
  	
  	// Disallow incorrect data and provide feedback
  	if(!is_numeric($_POST['quantity'])||strpos($_POST['quantity'],'.')!==false){
      	header("location:index.php?integer=1");
    }else{
		if(isset($_COOKIE['shoppingCart'])){
			$cookieData = stripslashes($_COOKIE['shoppingCart']);

			$cartData = json_decode($cookieData, true);
		}else{
			$cartData = array();
		}

		$listItemId = array_column($cartData, 'itemId');

		// in_array: Checks if a value exists in an array
		if(in_array($_POST['id'], $listItemId)){
			foreach($cartData as $keys => $values){
				if($cartData[$keys]['itemId'] == $_POST['id']){
					$cartData[$keys]['itemQuantity'] = $cartData[$keys]['itemQuantity'] + $_POST['quantity'];
				}
			}
		}elseif(!isset($_POST['extraNamePrice'])){
          	$itemArray = array(
				'itemId'				=>	$_POST['id'],
				'itemName'				=>	$_POST['name'],
          		'itemDescription'		=>	$_POST['description'],
				'itemPrice'				=>	$_POST['price'],
				'itemQuantity'			=>	$_POST['quantity'],
              	'itemExtraNamePrice'	=>	0
			);
			$cartData[] = $itemArray;
        }else{
			$itemArray = array(
				'itemId'				=>	$_POST['id'],
				'itemName'				=>	$_POST['name'],
          		'itemDescription'		=>	$_POST['description'],
				'itemPrice'				=>	$_POST['price'],
				'itemQuantity'			=>	$_POST['quantity'],
              	'itemExtraNamePrice'	=>	$_POST['extraNamePrice']
			);
			$cartData[] = $itemArray;
		}

		$itemData = json_encode($cartData);

		// setting expiration time of the cookie to 30 days
		setcookie('shoppingCart', $itemData, time() + (3600 * 24 * 30));
		header("location:index.php?added=1");
	}
  	
}
/*
if(isset($_POST['addToCart'])){
  
	// Disallow incorrect data and provide feedback
  	if(!is_numeric($_POST['quantity'])||strpos($_POST['quantity'],'.')!==false){
      header("location:index.php?integer=1");
    }else{
		if(isset($_COOKIE['shoppingCart'])){
			$cookieData = stripslashes($_COOKIE['shoppingCart']);

			$cartData = json_decode($cookieData, true);
		}else{
			$cartData = array();
		}

		$listItemId = array_column($cartData, 'itemId');

		// in_array: Checks if a value exists in an array
		if(in_array($_POST['id'], $listItemId)){
			foreach($cartData as $keys => $values){
				if($cartData[$keys]['itemId'] == $_POST['id']){
					$cartData[$keys]['itemQuantity'] = $cartData[$keys]['itemQuantity'] + $_POST['quantity'];
				}
			}
		}elseif(is_null($_POST['extraNamePrice'])){
          	$itemArray = array(
				'itemId'				=>	$_POST['id'],
				'itemName'				=>	$_POST['name'],
          		'itemDescription'		=>	$_POST['description'],
				'itemPrice'				=>	$_POST['price'],
				'itemQuantity'			=>	$_POST['quantity'],
              	'itemExtraNamePrice'	=>	0
			);
			$cartData[] = $itemArray;
        }else{
			$itemArray = array(
				'itemId'				=>	$_POST['id'],
				'itemName'				=>	$_POST['name'],
          		'itemDescription'		=>	$_POST['description'],
				'itemPrice'				=>	$_POST['price'],
				'itemQuantity'			=>	$_POST['quantity'],
              	'itemExtraNamePrice'	=>	$_POST['extraNamePrice']
			);
			$cartData[] = $itemArray;
		}

		$itemData = json_encode($cartData);

		// setting expiration time of the cookie to 30 days
		setcookie('shoppingCart', $itemData, time() + (3600 * 24 * 30));
		header("location:index.php?added=1");
	}
}
*/
if(isset($_GET['action'])){
	if($_GET['action'] == 'delete'){
		$cookieData = stripslashes($_COOKIE['shoppingCart']);
		$cartData = json_decode($cookieData, true);
		foreach($cartData as $keys => $values){
			if($cartData[$keys]['itemId'] == $_GET["id"]){
				unset($cartData[$keys]);
				$itemData = json_encode($cartData);
				// setting expiration time of the cookie to 30 days
				setcookie("shoppingCart", $itemData, time() + (3600 * 24 * 30));
				header("location:index.php?remove=1");
			}
		}
	}
	if($_GET["action"] == "clear"){
		setcookie("shoppingCart", "", time() - 3600);
		header("location:index.php?clearcart=1");
	}
}
// get the operation status and show message.
if(isset($_GET["integer"])){
	$showMessage = '<div align="center" class="alert alert-warning" role="alert">Only integer!</div>';
}

if(isset($_GET["added"])){
	$showMessage = '<div align="center" class="alert alert-success" role="alert">Item has been added to the shopping cart.</div>';
}

if(isset($_GET["remove"])){
	$showMessage = '<div align="center" class="alert alert-warning" role="alert">Item has been removed from shopping cart.</div>';
}

if(isset($_GET["clearcart"])){
	$showMessage = '<div align="center" class="alert alert-danger" role="alert">Shopping cart has been emptied.</div>';
}
