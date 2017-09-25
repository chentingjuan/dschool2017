<?php

use Illuminate\Database\Seeder;

use App\Activity;
class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::truncate();
        $data=[
            "type" => "workshop",
            "title"=> "Secret Wood Rings<br>木戒指工作坊",
            "description"=> "風靡全球的  Secret Wood Rings 利用原木與環氧樹脂創造美到令人窒息的魔幻感，讓全世界Maker摩拳擦掌，造就許多能在家DIY的方式。<br><br>實作中心本學期的第一堂工作坊，把夢幻化做現實，做出神美木戒指！<br>在這堂課中，你將學到：環氧樹脂固化；異材質拼接技術；鑽床、帶鋸機與砂輪機等機具操作；打磨與拋光加工技法。",
            "place"=> "創新設計學院實作中心",
            "time"=> "2017/10/18",
            "time_detail"=> "106/10/18、20",
            "detail"=> "",
            "register_info"=> "<h5>注意事項</h5><br>- 報名成功需於第一堂上課時繳交保證金200元，兩堂課皆需到場，缺課將沒收保證金  (會開立課程收據)<br>- 報名成功將會以E-mail通知，請注意繳費時間",
            "teacher"=> json_encode([
                [
                    "name"=> "李品緯",
                    "description"=> "萬能小精靈，可單手扛木板也可雙手做精工的神人！",
                    "other"=> "經歷：<br>O2O水資源藍色遊戲專案設計師。<br>學院面對空間計畫實作教練。<br>創新設計學院金牌助教。<br>D-Plan「開門工作室-keyman」團隊，「構宅青年」實作競賽全國冠軍隊伍。<br>建中木棧板傢俱工作坊實作教練。<br>木戒指工作坊講師。"
                ]
            ]),
            "cover"=> json_encode(["https://i.imgur.com/JSqa6ZI.jpg"]),
            "album"=> json_encode([
                [
                    "image"=> "https://i.imgur.com/2ftFdgm.jpg",
                    "caption"=> "講師作品（樹脂與木材的其他應用）"
                ],
                [
                    "image"=> "https://i.imgur.com/czjcppM.jpg",
                    "caption"=> "固化完成後的塑形。"
                ],
                [
                    "image"=> "https://i.imgur.com/Knvsvn5.jpg",
                    "caption"=> "表面處理階段，經水砂紙打磨。"
                ]
            ]),
        ]
        ;
        // "imgurset"=> "https://imgur.com/a/C96dO"
        
        Activity::create(         
            $data
        );
        //
    }
}
