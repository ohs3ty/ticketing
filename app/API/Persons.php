<?php

namespace App\API;

class Persons extends API
{
    public function __construct()
    {
        $this->url = "https://api.byu.edu:443/byuapi/persons/v3/";
    }

    const ACCESS_ITEM = [
        "age" => "vital_record",
        "attended_byu" => "student_summary",
        "birth_country_code" => "personal_record",
        "birthday" => "personal_record",
        "byu_id" => "",
        "citizenship_country_code" => "personal_record",
        "current_student" => "student_summary",
        "date_of_birth" => "vital_record",
        "deceased" => "",
        "department" => "",
        "eligible_to_register" => "student_summary",
        "email_address" => "email_addresses",
        "email_address_type" => "email_addresses",
        "employee_classification_code" => "employee_summary",
        "employee_role" => "employee_summary",
        "employee_standing_code" => "employee_summary",
        "employee_status_code" => "employee_summary",
        "first_name" => "",
        "high_school_city" => "personal_record",
        "high_school_code" => "personal_record",
        "high_school_state_code" => "personal_record",
        "hire_date" => "employee_summary",
        "home_country_code" => "",
        "home_state_code" => "",
        "home_town" => "",
        "job_code" => "employee_summary",
        "marital_status" => "vital_record",
        "merge_in_process" => "",
        "middle_name" => "",
        "name_fnf" => "",
        "name_lnf" => "",
        "net_id" => "",
        "person_id" => "",
        "personal_email_address" => "",
        "preferred_first_name" => "",
        "preferred_name" => "",
        "preferred_surname" => "",
        "religion_code" => "personal_record",
        "religion_tenure" => "personal_record",
        "reports_to_byu_id" => "employee_summary",
        "rest_of_name" => "",
        "restricted" => "vital_record",
        "sex" => "",
        "student_status" => "student_summary",
        "suffix" => "",
        "surname" => "",
        "unlisted" => "email_addresses",
        "visa_type" => "personal_record",
        "visa_type_source" => "personal_record",
        "verified_flag" => "email_addresses",
    ];

    const ITEMS = [
        '' => [
            "byu_id",
            "person_id",
            "net_id",
            "personal_email_address",
            "deceased",
            "sex",
            "first_name",
            "middle_name",
            "surname",
            "suffix",
            "preferred_first_name",
            "preferred_surname",
            "rest_of_name",
            "name_lnf",
            "name_fnf",
            "preferred_name",
            "home_town",
            "home_state_code",
            "home_country_code",
            "merge_in_process",
        ],
        'email_addresses' => [ // types = PERSONAL | WORK | SECURITY
            [
                "email_address_type",
                "email_address",
                "unlisted",
                "verified_flag",
            ],
        ],
        'employee_summary' => [
            "employee_role",
            "employee_classification_code",
            "employee_status_code",
            "employee_standing_code",
            "department",
            "job_code",
            "hire_date",
            "reports_to_byu_id",
        ],
        'personal_record' => [
            "birthday",
            "religion_code",
            "religion_tenure",
            "visa_type",
            "visa_type_source",
            "high_school_code",
            "high_school_city",
            "high_school_state_code",
            "citizenship_country_code",
            "birth_country_code",
        ],
        'student_summary' => [
            "student_status",
            "current_student",
            "eligible_to_register",
            "attended_byu",
        ],
        'vital_record' => [
            "age",
            "date_of_birth",
            "marital_status",
            "restricted",
        ],
    ];
}
