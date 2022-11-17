<?php 

if (!function_exists('makeList')) {
    function makeList(string $t, string $dl) 
    {
        $ul = '<ul>[content]</ul>';
        $li = '<li>[content]</li>';

        $content = explode($dl, $t);
        $result  = '';
        for ($i=0; $i < count($content); $i++) { 
            $result .= str_replace('[content]', $content[$i], $li);
        }

        return str_replace('[content]', $result, $ul);
    }
}