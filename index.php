<?php 
/**
 * index.php
 *
 * This is the main page. It includes HTML and PHP.
 * It calls items.php, cart.php, header.php, and footer.php
 *
 * @package ITC250
 * @authors Aaron Lewis <aaron.lewis@seattlcentral.edu>, Liyun Cecil <liyuncecil@gmail.com>, Derrick Mou <jtrvsconan@gmail.com>, Derek Hendrick <mooserkay@gmail.com>
 * @version 1.1 2019/2/14
 * @link http://derekheducation.dreamhosters.com/p3/index.php
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 */

include 'includes/items.php';
include 'includes/cart.php';
include 'includes/header.php'; ?>

    <div id="page">
      <h1 align="center">Food Truck</h1>
      <h3 align="center">You know you are hungry, order now!</h3>
    <div class="container">
      <h3 align="center">Menu</h3>
      <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col">Price</th>
              <th scope="col">Inventory</th>              
              <th scope="col">Quantity</th>
              <th scope="col"></th> 
            </tr>
          </thead>
          <tbody>

<?php
//index.php
$cost = 0;
$number_of_items = 0;
foreach($items as $item){
    $cost += $item->Price;
    $number_of_items++;
    //loop through the data
?>
    	  <tr>
          <form method='post'>
          <input type='hidden' name='id' value='<?php echo $item->ID; ?>' />
            
          <input type='hidden' name='name' value='<?php echo $item->Name; ?>' />
          <td><?php echo $item->Name; ?></td>
            
          <input type='hidden' name='description' value='<?php echo $item->Description; ?>' />
          <td><?php echo $item->Description; ?></td>
          
		  <input type='hidden' name='price' value='<?php echo $item->Price; ?>' />
          <td>$ <?php echo $item->Price; ?></td>
            
          <td><?php echo $item->Inventory; ?></td>
          
          <td>
          	<input type='text' name='quantity' value='1' class='form-control' />
          </td>
          
            <tr>
            
  			<thead>
            <tr>
              <th scope="col">Extra</th>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col"></th>              
              <th scope="col"></th>
              <th scope="col"></th> 
            </tr>
          	</thead>
             <?php
  
  			$extraNumber = 0;
  			foreach($item->Extras as $extra)
            {
              	?>
              	
                <td>
            	<div class="form-check form-check-inline">
                  	<!--<input type='hidden' name='extraName[]' value='' />-->
            		<input class='form-check-input' type='checkbox' name='extraNamePrice[]' value='<?php echo $item->ExtrasId[$extraNumber];?>,<?php echo $extra;?>,<?php echo $item->ExtrasMo[$extraNumber];?>'>
  					<label class="form-check-label" for="inlineCheckbox1"><?php echo $extra;?></label> &nbsp;&nbsp;&nbsp;$<?php echo $item->ExtrasMo[$extraNumber];?>
				</div>
        
               <?php
              $extraNumber ++;
             }
			?>
              
              <td></td>
            </tr>
       
        
              
          
          <td colspan="6" align="right">
         	<input type='submit' name='addToCart' style='margin-top:5px;' class='btn btn-success' value='Add to Cart' />
          </td>
          </form>
          </tr>
<?php
}
?>
               
          </tbody>
      </table>  
      

			<h3>Order Details</h3>
			<div class="table-responsive">
			<?php echo $showMessage; ?>
			<div align="right">
				<a href="index.php?action=clear"><button type="button" class="btn btn-warning">Clear Cart</button></a>
			</div>
			<table class="table table-bordered">
				<tr>
					<th width="10%">Name</th>
                  	<th width="30%">Extra Description</th>
                  	<th width="10%">Price</th>
					<th width="10%">Quantity</th>
					<th width="15%">Total</th>
					<th width="5%">Action</th>
				</tr>
			<?php
			if(isset($_COOKIE["shoppingCart"])){
				// test $_COOKIE
              	//echo $results = print_r($_COOKIE, true);
              	$total = 0;
                
                $tax_total = 0;
                $total_bill_due = 0;
                
                
				$cookieData = stripslashes($_COOKIE['shoppingCart']);
              	// test $cookieData
              	//echo $results = print_r($cookieData, true);
				$cartData = json_decode($cookieData, true);
				foreach($cartData as $keys => $values){
			?>
				<tr>
					<td><?php echo $values['itemName']; ?></td>
                  	<td>
                      <?php
                  	if($values['itemExtraNamePrice'] == 0){
                      echo 'No Extra';
                    }else
                    {
                      $number = 0;
                      $resultExTotal = 0;
                      $extraIdToItem = '';
                      foreach($values['itemExtraNamePrice'] as $result) 
                      {
                        $number ++;
                        $resultEx = explode(",", $result);
                        
                        echo $resultEx[1]. '&nbsp;$';
                        echo $resultEx[2];
                        echo str_repeat('&nbsp;', 8);
                        if(($number) % 2 == 0){
                        	echo '<br>';
                        }
                        $resultExTotal += $resultEx[2]; 
                        $extraIdToItem .= $resultEx[0];
                        
                      }
                      if($number % 2 == 1){
                        echo '<br>';
                      }
                      echo 'Extra Total: $'. $resultExTotal;
                      //test
                      //echo '<br>Extra ID: '. $values['itemId'] . $extraIdToItem;
                    }
                      ?>
                  	</td>
                  
                  	<td>$ <?php echo $values['itemPrice']; ?></td>
					<td><?php echo $values['itemQuantity']; ?></td>
				<?php
                  	if($values['itemExtraNamePrice'] == 0){
                      $subTotal =  $values['itemQuantity'] * $values['itemPrice'];
                    }else{
                      $subTotal =  $values['itemQuantity'] * ($values['itemPrice'] + $resultExTotal);
                    }   
                  ?>
					<td>$ <?php echo number_format($subTotal, 2);?></td>
					<td><a href="index.php?action=delete&id=<?php echo $values['itemId']; ?>"><button type="button" class="btn btn-danger">Remove</button></a></td>
				</tr>
			<?php	
					
                    $total = $total + $subTotal;
                    $tax_rate = 0.10 ; // Seattle Sales Tax Rate
                    $tax_total = $tax_rate * $total ; 
                    
                    $total_bill_due = $tax_total + $total ;
				}
			?>
                
                
<!-- AARON HACK TIME BELOW -->
                <tr>
					<td colspan="4" align="right">Sub-Total</td>
					<td align="right">$ <?php echo number_format($total, 2); ?></td>
					<td></td>
				</tr>
                
                <tr>
					<td colspan="4" align="right">Tax</td>
					<td align="right">$ <?php echo number_format($tax_total, 2); ?></td>
					<td></td>
				</tr>
<!-- AARON HACK TIME ABOVE -->                

                <tr>
					<td colspan="4" align="right">Total Bill Due</td>
					<td align="right">$ <?php echo number_format($total_bill_due, 2); ?></td>
					<td></td>
				</tr>


			<?php
			}else{
				echo '<tr><td colspan="6" align="center">Nothing in the cart</td></tr>';
			}
			?>
			</table>
			</div>
		</div>
    </div>
<?php include 'includes/footer.php'; ?>