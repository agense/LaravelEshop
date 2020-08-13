<?php
namespace App\Traits;

trait ProcessingHandlers {
    /**
     * Sets handler informtion or order payment and delivery processing.
     * Only allows admin users to be processing handlers
     * @return Void
     */
    public function assignHandler(){
        if(auth()->user() && auth()->user() instanceof \App\Models\Admin){
            $this->handler_role = auth()->user()->role;
            $this->handler_name = auth()->user()->name;
        }
    }

    /**
     * Gets handler informtion of order payment and delivery processing 
     * @return String
     */
    public function getHandlerInfo(){
        return ucwords($this->handler_role).' | '.ucwords($this->handler_name);
    }
}