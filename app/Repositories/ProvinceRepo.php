<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 05/05/2018
 * Time: 12:36
 */

namespace App\Repositories;



class ProvinceRepo extends GuzzleHttpRequest
{

    public function all()
    {
        $provinces = $this->get('provinces/all');
        return $provinces;
    }

}