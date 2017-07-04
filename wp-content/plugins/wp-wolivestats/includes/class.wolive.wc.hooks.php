<?php


class Wolive_wc_hooks {

		private $hooks =  null;
		public function __construct() {
			$this->setHooks();
		}


                public function setHooks () {

                // actions

                WL()->addActionType(array (
                        "name" => "add_to_cart",
                        "title"=> "Add to cart"
                ));
                WL()->addActionType(array (
                        "name" => "remove_to_cart",
                        "title"=> "Add to cart"
                    ));

                WL()->addActionType(array (
                        "name" => "wc_new_order",
                        "title"=> "New order"
                    ));


                WL()->addActionType(array (
                        "name" => "add_coupon",
                        "title"=> "Applied coupon"
                ));


                $this->hooks =  array();
                $this->hooks[]= array ( 
                        "hook" => "woocommerce_add_to_cart", 
                        "method" =>array($this, "woocommerce_add_to_cart") ,
                        "type" => "action" 
                );

                $this->hooks[]= array ( 
                        "hook" => "woocommerce_cart_item_removed", 
                        "method" =>array($this,"woocommerce_cart_item_removed"),
                        "type" => "action"
		    );

             	$this->hooks[]= array ( 
                        "hook" => "woocommerce_new_order", 
                        "method" =>array($this,"woocommerce_new_order"),
                        "type" => "action"
                    );

             	$this->hooks[]= array ( 
                        "hook" => "woocommerce_applied_coupon", 
                        "method" =>array($this,"woocommerce_applied_coupon"),
                        "type" => "action"
                );



		}


        public function registerHooks () {
                foreach ($this->hooks as $hook) {
			if ($hook["type"] == "action" ) {
                       add_action($hook["hook"],  $hook["method"]);
                   	}
               }
        }

	public function woocommerce_add_to_cart ($product_id) {		
                $data = array();
		$data["id"] = WC()->cart->cart_contents[$product_id]["product_id"];
		$qty = WC()->cart->cart_contents[$product_id]["quantity"];
		$data["value"] = json_encode(array("quantity" => $qty));

		WL()->addAction("add_to_cart", $data);
        }

        public function woocommerce_cart_item_removed ($product_id) {
                $data = array();
                $data["id"] = WC()->cart->removed_cart_contents[$product_id]["product_id"];
                WL()->addAction("remove_to_cart", $data);
	}

	public function woocommerce_new_order ($order_id) {
		$data["id"] = $order_id;
                WL()->addAction("wc_new_order", $data);
        }

        public function woocommerce_applied_coupon ($coupon) {
		$data["value"] = json_encode(array("coupon" => $coupon));
                WL()->addAction("add_coupon", $data);
        }
}


/*
woocommerce_cart_reset
woocommerce_checkout_init
woocommerce_checkout_order_processed	
woocommerce_checkout_process

woocommerce_coupon_loaded
woocommerce_shipping_method_chosen
*/
