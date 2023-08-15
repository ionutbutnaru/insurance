<?php

namespace App\Helpers;
use App\Constants\CnpRulesConstants;

class CnpValidator
{

    public static function validateCnp($cnp)
    {
        return [
            'digits_and_length' => self::validateDigitsAndLength($cnp),
            'gender' => self::validateGender($cnp),
            'year' => self::validateYear($cnp),
            'month' => self::validateMonth($cnp),
            'day' => self::validateDay($cnp),
            'county' => self::validateCountyCode($cnp),
            'sequential' => self::validateSequential($cnp),
        ];
    }

    public static function validateDigitsAndLength($cnp)
    {
        $message = false;
        if (strlen($cnp) != 13) {
            $message = 'The cnp must be 13 digits long';
        } else if (!ctype_digit($cnp)) {
            $message = 'CNP must be formed only with digits';
        }
        return $message;
    }

    public static function validateGender($cnp)
    {

        $validGenders = [
            'male' => CnpRulesConstants::MALE_CODES,
            'female' => CnpRulesConstants::FEMALE_CODES
        ];

        $cnpFirstDigit = intval(substr($cnp, 0, 1));
        $message = 'Inserted gender code is not valid';

        foreach ($validGenders as $gender => $validDigits) {
            if (in_array($cnpFirstDigit, $validDigits)) {
                $message = false;
            }
        }
        return $message;
    }

    public static function validateYear($cnp)
    {
        $year = substr($cnp, 1, 2);
        $message = 'The inserted year is not valid';
        if ($year >= 0 && $year <= 99) {
            $message = false;
        }
        return $message;
    }
    public static function validateMonth($cnp)
    {

        $cnpMonthDigits = substr($cnp, 3, 2);
        $cnpMonth = intval($cnpMonthDigits);
        $message = 'The inserted month is not valid';
        if ($cnpMonth >= 1 && $cnpMonth <= 12) {
            $message = false;
        }
        return $message;
    }

    public static function validateDay($cnp)
    {
        $day = substr($cnp, 5, 2);
        $message = 'Please insert a valid day';
        if (strlen($day) === 2 && is_numeric($day)) {
            $day = intval($day);
            if ($day >= 1 && $day <= 31) {
                $message = false;
            }
        }
        return $message;
    }

    public static function validateCountyCode($cnp)
    {

        $countyCode = substr($cnp, 7, 2);
        $message = 'County code you inserted is not valid.';
        if (isset(CnpRulesConstants::COUNTY_CODES[$countyCode])) {
            $message = false;
        }
        return $message;
    }

    public static function validateSequential($cnp)
    {
        $sequential = intval(substr($cnp, 9, 3));
        $message = 'Sequential number is not valid';
        if ($sequential >= 1 && $sequential <= 999) {
            $message = false;
        }
        return $message;
    }
}
