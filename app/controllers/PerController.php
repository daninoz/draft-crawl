<?php

use jyggen\Curl;
use Symfony\Component\DomCrawler\Crawler;

class PerController extends BaseController
{
    public function create()
    {
        $players = Player::where('link', '!=', '')->skip(0)->take(100)->get();
        foreach ($players as $player) {
            $curl = Curl::get("http://www.basketball-reference.com".$player->link);

            $html = $curl[0]->getContent();

            $crawler = new Crawler($html);

            $crawler = $crawler->filter('#advanced > tfoot > tr:not(.partial_table)');


            $crwl = $crawler->eq(0);
            $player->per = $crwl->filter('td')->eq(7)->html();

            $player->save();

        }
    }
}