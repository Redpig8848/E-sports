<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    //
    protected $table = 'match';



    public function GetMatchId($events){
        $events_id = $this->where('match',$events)->select('id')->get()->toArray();
        return $events_id ? $events_id[0]['id'] : false;


    }





}
