<?php
namespace App\Helpers;

use App\Models\Admin\Settings;

class Currency {
    /**
     * This function formats the currency as per the currency format in account settings
     *
     * $input format is xxxxxxx.xx
     */
    static function curreny_format($input) {
        // In Settings Table, ID 2 is for Currency Format
//        switch (Settings::find(2)->toArray()['description']) {
//            case 'none':
//                return $input;
//            case '##,###.##':
//                return self::_currency_2_3_style($input);
//                break;
//            case '##,##.##':
//                return self::_currency_2_2_style($input);
//                break;
//            case "###,###.##":
//                return self::_currency_3_3_style($input);
//                break;
//            default:
//                die("Invalid curreny format selected.");
//        }
    // return number_format($input,2);
        return number_format($input);
    }

    /*
     * Function to get decimal positions
     */
    static function _decimal_places() {
        return 0;
    }

    /*********************** ##,###.## FORMAT ***********************/
    static function _currency_2_3_style($num)
    {
        $decimal_places = self::_decimal_places();

        $pos = strpos((string)$num, ".");
        if ($pos === false) {
            if ($decimal_places == 2) {
                $decimalpart = "00";
            } else {
                $decimalpart = "000";
            }
        } else {
            $decimalpart = substr($num, $pos + 1, $decimal_places);
            $num = substr($num, 0, $pos);
        }

        if (strlen($num) > 3) {
            $last3digits = substr($num, -3);
            $numexceptlastdigits = substr($num, 0, -3 );
            $formatted = self::_currency_2_3_style_makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last3digits . "." . $decimalpart ;
        } elseif (strlen($num) <= 3) {
            $stringtoreturn = $num . "." . $decimalpart;
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {
            $stringtoreturn = "-" . substr($stringtoreturn, 2);
        }
        return $stringtoreturn;
    }

    static function _currency_2_3_style_makecomma($input)
    {
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = self::_currency_2_3_style_makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }

    /*********************** ##,##.## FORMAT ***********************/
    static function _currency_2_2_style($num)
    {
        $decimal_places = self::_decimal_places();

        $pos = strpos((string)$num, ".");
        if ($pos === false) {
            if ($decimal_places == 2) {
                $decimalpart = "00";
            } else {
                $decimalpart = "000";
            }
        } else {
            $decimalpart = substr($num, $pos + 1, $decimal_places);
            $num = substr($num, 0, $pos);
        }

        if (strlen($num) > 2) {
            $last2digits = substr($num, -2);
            $numexceptlastdigits = substr($num, 0, -2);
            $formatted = self::_currency_2_2_style_makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last2digits . "." . $decimalpart;
        } elseif (strlen($num) <= 2) {
            $stringtoreturn = $num . "." . $decimalpart ;
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {
            $stringtoreturn = "-" . substr($stringtoreturn, 2);
        }
        return $stringtoreturn;
    }

    static function _currency_2_2_style_makecomma($input)
    {
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = self::_currency_2_2_style_makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }

    /*********************** ###,###.## FORMAT ***********************/
    static function _currency_3_3_style($num)
    {
        $decimal_places = self::_decimal_places();
        return number_format($num,$decimal_places,'.',',');
    }
}