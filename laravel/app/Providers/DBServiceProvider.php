<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder as QueryBuilder;

class DBServiceProvider extends ServiceProvider
{
    public function boot()
    {
        QueryBuilder::macro('lists',function()
        {
            $data = $this->get()->toArray();
            $result = [];
            foreach($data as $val){
                $result[] = (array)$val;
            }
            return $result;
        });

        QueryBuilder::macro('item',function()
        {
            $data = $this->get()->first();
            $data = (array)$data;
            return $data;
        });
        QueryBuilder::macro('cates',function($index)
        {
            $data = $this->get()->toArray();
            $res = [];
            foreach($data as $value){
                $res[$value->$index]= (array)$value;
            }
            return $res;
        });
    }
}
