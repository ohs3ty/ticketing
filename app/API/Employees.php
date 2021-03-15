<?php

namespace App\API;

class Employees extends API
{
    public function __construct()
    {
        $this->url = "https://api.byu.edu:443/byuapi/employees/v1/";
    }

    const ACCESS_ITEM = [
        "byu_id" => "",
        "date_of_birth" => "date_of_birth",
        "first_name" => "",
        "middle_name" => "",
        "net_id" => "",
        "original_hire_date" => "hr_data",
        "primary_hr_status" => "",
        "surname" => "",
    ];

    const ITEMS = [
        "" => [
            // primary_hr_status -> "Designates whether a person is currently an employee or a 
            //      BYU affiliated employee (e.g., LDS Philanthropies, ROTC, etc.). 
            //      The two values are Active and Inactive. The "Restricted Flag" 
            //      will restrict access where the restricted flag has been selected."
            "primary_hr_status",
            "byu_id",
            "surname",
            "net_id",
            "middle_name",
            "first_name",
        ],
        "hr_data" => [
            // original_hire_date -> "The earliest date that an employee started employment at 
            //      BYU as either a part-time or full-time employee."
            "original_hire_date",
        ],
        "date_of_birth" => [
            "date_of_birth",
        ],
    ];
}