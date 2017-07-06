<?php



class Wolive_actions_types {


        private $actions_types = array();

        public function __construct () {

        }

        // Add New action Type
        // name
        // Title
        public  function addActionType ($action_type) {
                // Check key-name.

                if (isset($action_type["name"]) and strlen($action_type["name"]) < 18 and strlen($action_type["name"])>2 )
                {
                        $this->actions_types[$action_type["name"]] = $action_type;
                }
        }

        public function getAction ($key_name) {
                if (isset($this->actions_types[$key_name])) {
                        return $this->actions_types[$key_name];      
                }
                return  0;
        }

        
}
