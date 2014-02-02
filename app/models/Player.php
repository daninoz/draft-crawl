<?php

class Player extends Eloquent
{
    public function seasons()
    {
        return $this->belongsToMany('Season')->withPivot('per', 'games');
    }
}