<?php

class Season extends Eloquent
{
    protected $fillable = ['year'];

    public function players()
    {
        return $this->belongsToMany('Player')->withPivot('per', 'games');
    }
}