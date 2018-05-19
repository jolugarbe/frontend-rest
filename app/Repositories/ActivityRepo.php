<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 05/05/2018
 * Time: 12:36
 */

namespace App\Repositories;



class ActivityRepo extends GuzzleHttpRequest
{

    public function all()
    {
        $activities = $this->get('activities/all');
        return $activities;
    }

}