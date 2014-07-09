<?php

namespace CercaniasApi\Result;

use Cercanias\Provider\AbstractProvider;

class RoutesResult
{
    public function toArray()
    {
        return array(
            "routes" => $this->getRoutes()
        );
    }

    protected function getRoutes()
    {
        return  array(
            array("id" => AbstractProvider::ROUTE_ASTURIAS          , "name" => "Asturias"),
            array("id" => AbstractProvider::ROUTE_BARCELONA         , "name" => "Barcelona"),
            array("id" => AbstractProvider::ROUTE_BILBAO            , "name" => "Bilbao"),
            array("id" => AbstractProvider::ROUTE_CADIZ             , "name" => "Cádiz"),
            array("id" => AbstractProvider::ROUTE_MADRID            , "name" => "Madrid"),
            array("id" => AbstractProvider::ROUTE_MALAGA            , "name" => "Málaga"),
            array("id" => AbstractProvider::ROUTE_MURCIA_ALICANTE   , "name" => "Murcia-Alicante"),
            array("id" => AbstractProvider::ROUTE_SAN_SEBASTIAN     , "name" => "San Sebastián"),
            array("id" => AbstractProvider::ROUTE_SANTANDER         , "name" => "Santander"),
            array("id" => AbstractProvider::ROUTE_SEVILLA           , "name" => "Sevilla"),
            array("id" => AbstractProvider::ROUTE_VALENCIA          , "name" => "Valencia"),
            array("id" => AbstractProvider::ROUTE_ZARAGOZA          , "name" => "Zaragoza"),

        );
    }
}