<?php

if (! function_exists('mb_ucfirst')) {
    function mb_ucfirst($string) {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }
}

if (! function_exists('str_ucwords')) {
    function str_ucwords($string) {
        $retorno  = [];
        $string   = mb_strtolower(trim(preg_replace('/\s+/', ' ', $string)));
        $palavras = explode(' ', $string);

        $retorno[] = mb_ucfirst($palavras[0]);
        unset($palavras[0]);

        foreach ($palavras as $palavra) {
            if (!preg_match("/^([dn]?[aeiou]?|em)$/i", $palavra)) {
                $palavra = mb_ucfirst($palavra);
            }
            $retorno[] = $palavra;
        }

        return implode(' ', $retorno);
    }
}
