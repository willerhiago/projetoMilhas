<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities;

class FlightController extends Controller {

    private $baseUrl = "http://prova.123milhas.net/flights";
    private $uniqueID = 1;
    
    /**
     * Show all flights.
     */
    public function allFlights() {
        return Utilities::callAPI('GET', $this->baseUrl);
    }

    /**
     * Show filtered flights.
     */
    public function flights($type, $nome){
        return Utilities::callAPI('GET', "$this->baseUrl?$type=$nome");
    }

     /**
     * Show groups of flights.
     */
    public function groups() {
        $flights = Utilities::callAPI('GET', $this->baseUrl);
        $fareTypes = [];
        // retrieve all fareTypes
        foreach($flights as $flight) {
            if(!in_Array($flight['fare'], $fareTypes)) array_push($fareTypes, $flight['fare']);
        }

        // build groups per fare
        $groups = [];
        foreach($fareTypes as $fare) {
            $outbounds = Utilities::callAPI('GET', "$this->baseUrl?fare=$fare&outbound=1");
            $inbounds = Utilities::callAPI('GET', "$this->baseUrl?fare=$fare&inbound=1");
            
            $outbounds = $this->groupByPrice($outbounds);
            $inbounds = $this->groupByPrice($inbounds);

            $groups = array_merge($groups, $this->groupFlights($outbounds, $inbounds));
            
        }
        // sort by price
        usort($groups, function($a, $b) {
            return $a['totalValue'] <=> $b['totalValue'];
        });

        $result = [
            "flights" => $flights,
            "groups" => $groups,
            "totalGroups" => count($groups),
            "totalFlights" => count($flights),
            "cheapestPrice" => !empty($groups) ? $groups[0]['totalValue'] : 0,
            "cheapestGroup" => !empty($groups) ? $groups[0]['uniqueId'] : null
        ];
        
        return $result;
    }
    
    private function groupByPrice($bounds) {
        $priceGroups = [];
        $price = 0;
        $group = [];
        foreach($bounds as $data) {
            if($data['price'] != $price) {
                $price = $data['price'];
                if(!empty($group)) array_push($priceGroups, $group);
                $group = [];
            }
            array_push($group, $data);
        }
        array_push($priceGroups, $group);

        return $priceGroups;
    }

    private function groupFlights($outbounds, $inbounds){
        $groupFlights = [];
        foreach($outbounds as $out) {
            foreach($inbounds as $in) {
                $totalValue = $out[0]['price'] + $in[0]['price'];
                array_push($groupFlights, 
                    [
                        "uniqueId" => $this->uniqueID,
                        "totalValue" => $totalValue,
                        "outbound" => $out,
                        "inbound" => $in
                    ]
                );
                $this->uniqueID++;
            }
        }

        return $groupFlights;
    }

      /**
     * Show groups of flights.
     */
    public function groupsFilter($id = null) {
        $data = $this->groups();
        $groups = $data['groups'];
        if($id) {
            $result = array_filter($groups, function($item) use ($id){
                return $item['uniqueId'] == (int)($id);
            });
        } else $result = $groups[0];
        
        return $result;
    }
}