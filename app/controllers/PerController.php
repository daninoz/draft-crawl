<?php

use jyggen\Curl;
use Symfony\Component\DomCrawler\Crawler;

class PerController extends BaseController
{
    public function career()
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

    public function season()
    {
        $players = Player::where('link', '!=', '')->where('id', '>=', 2065)->where('draft', '>=', '1989')->where('draft', '<=', '2010')->get();

        foreach ($players as $player) {
            $curl = Curl::get("http://www.basketball-reference.com".$player->link);

            $html = $curl[0]->getContent();

            $crawler = new Crawler($html);

            $crawler = $crawler->filter('#advanced > tbody > tr.full_table');

            if ($players->seasons->count() > 0) {
                $player->seasons()->detach();
            }

            for ($i = 0; $i < $crawler->count(); $i++ ) {
                $crwl = $crawler->eq($i)->filter('td');

                $season = Season::firstOrCreate(['year' => $crwl->eq(0)->filter('a')->html()]);

                $season->players()->attach($player->id, ['per' => $crwl->eq(7)->html(), 'games' => $crwl->eq(5)->html()]);

                /*echo "Season: ".$crwl->eq(0)->filter('a')->html()."<br />";
                echo "Games: ".$crwl->eq(5)->html()."<br />";
                echo "OER: ".$crwl->eq(7)->html()."<br />";
                echo "<br />";*/
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

    public function ranking()
    {
        $players = Player::where('per', '!=', 'NULL')->where('draft', '>=', '1989')->where('draft', '<', '2009')->get();

        foreach ($players as $player) {
            $array_players[$player->id]['diff'] = $player->fixed_position-$player->position;
            $array_players[$player->id]['name'] = $player->name;
            $array_players[$player->id]['link'] = $player->link;
        }

        sort($array_players);

        foreach ($array_players as $position => $player)
        {
            echo "<p>".($position+1).": <a href='http://www.basketball-reference.com{$player['link']}'>{$player['name']}</a> {$player['diff']}</p>";
        }
    }
}