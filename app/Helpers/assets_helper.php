<?php

if(!function_exists('css_url')) {

    function css_url($nom)
    {
        return base_url().'/assets/css/'.$nom.'.css';
    }
}

 

if(!function_exists('js_url')) {
    function js_url($nom)
    {
        return base_url().'/assets/javascript/'.$nom.'.js';
    }
}

 

if(!function_exists('img_url')) {
    function img_url($nom)
    {
        return base_url().'/assets/images/'.$nom;
    }
}


if(!function_exists('img')) {
    function img($nom, $alt = '')
    {
        return '<img src="'.img_url($nom).'" alt="'.$alt.'" />';
    }
}

if(!function_exists('imga')) {
    function imga($nom, $attributs)
    {
        return '<img src="'.img_url($nom).'" '.$attributs.'/>';
    }
}