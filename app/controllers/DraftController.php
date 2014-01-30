<?php

use jyggen\Curl;
use Symfony\Component\DomCrawler\Crawler;

class DraftController extends BaseController
{
    public function create()
    {
        for ($year = 1980; $year < 2014; $year++) {
            $curl = Curl::get("http://www.basketball-reference.com/draft/NBA_{$year}.html");

            //return $curl[0]->getContent();

            $html = $curl[0]->getContent();

            $crawler = new Crawler($html);

            $crawler = $crawler->filter('#stats > tbody > tr:not(.thead)');

            $crawler->html();

            for ($i = 0; $i < $crawler->count(); $i++) {
                $crwl = $crawler->eq($i);
                $player = new Player;
                if ($crwl->filter('td')->eq(2)->filter('a')->count() > 0) {
                    $player->link = $crwl->filter('td')->eq(2)->filter('a')->attr('href');
                    $player->name = $crwl->filter('td')->eq(2)->filter('a')->html();
                } else {
                    $player->name = $crwl->filter('td')->eq(2)->html();
                }
                $player->position = $crwl->filter('td')->eq(0)->html();
                $player->draft = $year;
                $player->save();
            }
        }
    }
}