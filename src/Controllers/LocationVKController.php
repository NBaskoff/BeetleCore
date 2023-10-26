<?php

namespace BeetleCore\Controllers;

use BeetleCore\Fields\LocationVKField;

class LocationVKController extends Controller
{
    public function city()
    {
        $records = json_decode(LocationVKField::getVKData("database.getCities", [
            "country_id" => request("countryId"),
            "q" => request("query")
        ]), true)["response"]["items"];
        $records = array_map(function ($record) {
            if (!empty($record["region"])) {
                $record["value"] = "{$record["title"]}, {$record["region"]}";
            } else {
                $record["value"] = $record["title"];
            }
            return $record;
        }, $records);
        return ["suggestions" => $records];
    }
}
