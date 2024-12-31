<?php
interface Subject_Model {
    public function attach(Observer_Model $observer);
    public function detach(Observer_Model $observer);
    public function notify();
    
}
?>
