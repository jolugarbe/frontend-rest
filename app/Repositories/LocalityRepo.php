<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 05/05/2018
 * Time: 12:36
 */

namespace App\Repositories;



class LocalityRepo extends GuzzleHttpRequest
{

    public function all()
    {
        $localities = $this->get('localities/all');
        return $localities;
    }

}