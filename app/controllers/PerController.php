<?php

use jyggen\Curl;
use Symfony\Component\DomCrawler\Crawler;

class PerController extends BaseController
{
    public function create()
    {
        $players = Player::where('link', '!=', '')->where('per', '=', NULL)->get();

        foreach ($players as $player) {
            $curl = Curl::get("http://www.basketball-reference.com".$player->link);

            $html = $curl[0]->getContent();

            $crawler = new Crawler($html);

            $crawler = $crawler->filter('#advanced > tfoot > tr:not(.partial_table)');

            if ($crawler->count() > 0) {
                $crwl = $crawler->eq(0);
                $player->per = $crwl->filter('td')->eq(7)->html();

                $player->save();
            }

        }
    }

    public function reorder()
    {
        $players = Player::where('per', '!=', 'NULL')->get();

        foreach ($players as $player) {
            echo $player;
            $drafts[$player->draft][$player->position]['per'] = $player->per;
            $drafts[$player->draft][$player->position]['id'] = $player->id;
        }

        foreach ($drafts as &$draft) {
            rsort($draft);
        }

        foreach ($drafts as $draft) {
            foreach ($draft as $fixed_position => $player) {
                $db_player = Player::find($player['id']);
                $db_player->fixed_position = $fixed_position+1;
                $db_player->save();
            }
        }
    }
}