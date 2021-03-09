<?php

namespace App\API;

class Identities extends API
{
    public function __construct()
    {
        $this->url = "https://api.byu.edu:443/byuapi/identities/v2/";
    }

    const ACCESS_ITEM = [
        "byu_id" => "",
        "email_address" => "email_addresses",
        "email_address_type" => "email_addresses",
        "identity_name" => "",
        "identity_type" => "",
        "merge_in_process" => "",
        "net_id" => "",
        "person_id" => "",
        "related_byu_id" => "relationships",
        "related_name_fnf" => "relationships",
        "related_name_lnf" => "relationships",
        "related_net_id" => "relationships",
        "related_preferred_first_name" => "relationships",
        "related_preferred_name" => "relationships",
        "related_preferred_surname" => "relationships",
        "related_rest_of_name" => "relationships",
        "related_surname" => "relationships",
        "relationship_type" => "relationships",
        "restricted" => "",
        "test_record_responsible_byu_id" => "",
        "unlisted" => "email_addresses",
        "verified_flag" => "email_addresses",
    ];

    const ITEMS = [
        "" => [
            "byu_id",
            "person_id",
            "net_id",

            // identity_type -> "The type of identity"... duh
            //      I couldn't find anything else.
            //
            // example:
            //      "Person"
            "identity_type",

            // identity_name -> "The name of an Identity (e.g. a person, an 
            //      organization, a device, a process). The identity name of 
            //      a Person is the Preferred Name."
            //      
            // example: 
            //      "Bob Dole"
            "identity_name",

            "test_record_responsible_byu_id",
            "restricted",
            "merge_in_process",
        ],
        "email_addresses" => [
            [
                "email_address_type",
                "email_address",
                "unlisted",
                "verified_flag",
            ],
        ],
        "relationships" => [
            [
                "byu_id",
                "related_byu_id",
                "related_net_id",
                "relationship_type",
                "related_name_lnf",
                "related_name_fnf",
                "related_preferred_name",
                "related_surname",
                "related_rest_of_name",
                "related_preferred_surname",
                "related_preferred_first_name",
            ]
        ],
    ];
}