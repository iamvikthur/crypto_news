<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Facades\Telegraph;

class AppController extends Controller
{
    public function sendMessage()
    {
        $news = json_decode($this->getNews());
        $count = count($news);

        for ($i=0; $i < 3; $i++) { 
            $rand = rand(0, $count);

            $title = $news[$rand]->title;
            $url = $news[$rand]->url;
            $source = $news[$rand]->source;

            $html = "<strong>".$title."</strong>\n\n".$url."\n\nSource: ".$source;

            $msg = Telegraph::message($html)->send();

            print($msg);
        }
    }

    public function getNews()
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://crypto-news-live3.p.rapidapi.com/news",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: crypto-news-live3.p.rapidapi.com",
                "X-RapidAPI-Key: e90b5f8aacmshd2b05e0edb6d733p1d7310jsndbad63c8e3e0"
            ],
        ]);

        try {
            $response = curl_exec($curl);

            return $response;
        } catch (\Throwable $th) {
            $err = curl_error($curl);
            report($err);
            throw $th;
        }
        

        
        

        curl_close($curl);
    }
}
