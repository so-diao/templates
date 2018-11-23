<?php


/**
 * 
 * 钩子
 */

class Action {
    private $evs = array();
    public $option;

    public function __construct($option = array()) {

        $this->set_option($option);
    }

    public function set_option($option) {
        $this->option = $option;
    }

    public function get_option() {
        return $this->option;
    }

    public function do_action($action, ...$arg) {
        if ( !isset($this->evs[$action]) ) {
            return;
        }
        foreach ($this->evs[$action] as $fn) {
            call_user_func($fn, ...$arg);
        }
    }

    public function add_action($action, $cb) {
        if ( !isset($this->evs[$action]) ) {
            $this->evs[$action] = array();
        }
        array_push($this->evs[$action], $cb);
    }

    public function remove_action($action, $cb = null) {
        if ( !isset($this->evs[$action]) ) {
            return;
        }

        if ( isset($cb) ) {
            $key = array_search($cb, $this->evs[$action]);
            array_splice($this->evs[$action], $key, 1);
        } else {
            unset($this->evs[$action]);
        }
    }
}


$Action = new Action();

?>