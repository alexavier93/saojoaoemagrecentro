<?php 

if(!function_exists('get_youtubeid')){

    function get_youtubeid($url){

        $ytcheck = preg_match('![?&]{1}v=([^&]+)!', $url . '&', $data);

        if($ytcheck){
            $id_video = $data[1];
        }
        return $id_video;
    }

}

if ( ! function_exists('get_link')) {    
  
    function get_link($url){


        $link_check = preg_match('![?&]{1}v=([^&]+)!', $url . '://', $data);

        dd($link_check);

        if($link_check){
            $link = $data[1];
        }
        
        return $link;
    }

}

if (!function_exists('limpaCPF_CNPJ')) {

    function limpaCPF_CNPJ($valor)
    {

        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }
}
