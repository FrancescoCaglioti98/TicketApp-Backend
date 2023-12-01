<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{



    private string $userSeed = '[
        {"name":"Francesco","last_name":"Caglioti","email":"dummy@mail.it","is_admin":1,"is_active":1},
        {"name":"Nessy","last_name":"Bathowe","email":"nbathowe0@usnews.com","is_admin":0,"is_active":0},
        {"name":"Baryram","last_name":"Jennrich","email":"bjennrich1@abc.net.au","is_admin":0,"is_active":0},
        {"name":"Fara","last_name":"Meert","email":"fmeert2@soundcloud.com","is_admin":0,"is_active":0},
        {"name":"Beale","last_name":"Pixton","email":"bpixton3@google.com.br","is_admin":0,"is_active":1},
        {"name":"Windham","last_name":"Elsworth","email":"welsworth4@plala.or.jp","is_admin":0,"is_active":0},
        {"name":"Annabela","last_name":"Gehrts","email":"agehrts5@mozilla.com","is_admin":0,"is_active":1},
        {"name":"Abagail","last_name":"Boyson","email":"aboyson6@gov.uk","is_admin":0,"is_active":0},
        {"name":"Kimberli","last_name":"Waddup","email":"kwaddup7@latimes.com","is_admin":0,"is_active":1},
        {"name":"Dunc","last_name":"Ranfield","email":"dranfield8@tumblr.com","is_admin":0,"is_active":1},
        {"name":"Kristina","last_name":"Marzelle","email":"kmarzelle9@ifeng.com","is_admin":0,"is_active":0},
        {"name":"Toiboid","last_name":"Chatfield","email":"tchatfielda@paypal.com","is_admin":0,"is_active":0},
        {"name":"Rosanna","last_name":"Isitt","email":"risittb@yale.edu","is_admin":0,"is_active":1},
        {"name":"See","last_name":"Goffe","email":"sgoffec@meetup.com","is_admin":0,"is_active":0},
        {"name":"Patti","last_name":"Wones","email":"pwonesd@adobe.com","is_admin":0,"is_active":1},
        {"name":"Park","last_name":"Apedaile","email":"papedailee@163.com","is_admin":0,"is_active":0},
        {"name":"Monte","last_name":"Keepence","email":"mkeepencef@meetup.com","is_admin":0,"is_active":0},
        {"name":"Angelique","last_name":"Lighterness","email":"alighternessg@phoca.cz","is_admin":0,"is_active":1},
        {"name":"Cherianne","last_name":"Bellee","email":"cbelleeh@apache.org","is_admin":0,"is_active":1},
        {"name":"Arlena","last_name":"Haffenden","email":"ahaffendeni@joomla.org","is_admin":0,"is_active":0},
        {"name":"Krissy","last_name":"Redd","email":"kreddj@deviantart.com","is_admin":0,"is_active":0},
        {"name":"Hogan","last_name":"Troughton","email":"htroughtonk@google.com","is_admin":0,"is_active":1},
        {"name":"Anett","last_name":"Gunning","email":"agunningl@google.pl","is_admin":0,"is_active":0},
        {"name":"Angie","last_name":"Clowley","email":"aclowleym@yandex.ru","is_admin":0,"is_active":1},
        {"name":"Alaster","last_name":"Rawe","email":"arawen@psu.edu","is_admin":0,"is_active":1},
        {"name":"Carlina","last_name":"Neeves","email":"cneeveso@cbsnews.com","is_admin":0,"is_active":0},
        {"name":"Carlotta","last_name":"Sail","email":"csailp@ted.com","is_admin":0,"is_active":1},
        {"name":"Wakefield","last_name":"Baysting","email":"wbaystingq@toplist.cz","is_admin":0,"is_active":1},
        {"name":"Nick","last_name":"Fasey","email":"nfaseyr@google.cn","is_admin":0,"is_active":1},
        {"name":"Gasper","last_name":"Human","email":"ghumans@spiegel.de","is_admin":0,"is_active":0},
        {"name":"Tibold","last_name":"Ciobotaro","email":"tciobotarot@shinystat.com","is_admin":0,"is_active":0},
        {"name":"Archer","last_name":"Ricardin","email":"aricardinu@google.es","is_admin":0,"is_active":0},
        {"name":"Nathanial","last_name":"Tregenza","email":"ntregenzav@dmoz.org","is_admin":0,"is_active":1},
        {"name":"Marwin","last_name":"Burniston","email":"mburnistonw@sourceforge.net","is_admin":0,"is_active":1},
        {"name":"Sully","last_name":"Mattek","email":"smattekx@com.com","is_admin":0,"is_active":1},
        {"name":"Holly-anne","last_name":"Sushams","email":"hsushamsy@dagondesign.com","is_admin":0,"is_active":1},
        {"name":"Nappy","last_name":"Papaminas","email":"npapaminasz@1und1.de","is_admin":0,"is_active":0},
        {"name":"Meg","last_name":"Phonix","email":"mphonix10@sogou.com","is_admin":0,"is_active":0},
        {"name":"Cobb","last_name":"Eginton","email":"ceginton11@loc.gov","is_admin":0,"is_active":1},
        {"name":"Emylee","last_name":"McCory","email":"emccory12@fda.gov","is_admin":0,"is_active":1},
        {"name":"Maynord","last_name":"Girsch","email":"mgirsch13@booking.com","is_admin":0,"is_active":1},
        {"name":"Celle","last_name":"Spurdle","email":"cspurdle14@over-blog.com","is_admin":0,"is_active":0},
        {"name":"Sharai","last_name":"Kinningley","email":"skinningley15@utexas.edu","is_admin":0,"is_active":0},
        {"name":"Gusta","last_name":"Dils","email":"gdils16@patch.com","is_admin":0,"is_active":0},
        {"name":"Carlye","last_name":"Ellwand","email":"cellwand17@vk.com","is_admin":0,"is_active":1},
        {"name":"Ermengarde","last_name":"Ramas","email":"eramas18@timesonline.co.uk","is_admin":0,"is_active":0},
        {"name":"Johnna","last_name":"Scading","email":"jscading19@sun.com","is_admin":0,"is_active":1},
        {"name":"Glory","last_name":"Cargill","email":"gcargill1a@posterous.com","is_admin":0,"is_active":1},
        {"name":"Earlie","last_name":"Morrish","email":"emorrish1b@printfriendly.com","is_admin":0,"is_active":1},
        {"name":"Louise","last_name":"O\'Noulane","email":"lonoulane1c@arizona.edu","is_admin":0,"is_active":0},
        {"name":"Dorry","last_name":"Ferri","email":"dferri1d@hatena.ne.jp","is_admin":0,"is_active":0}]';


    private string $groupSeed = '[
        {"name":"Developers","description":"Gruppo di Test","user_admin_id":1},
        {"name":"FrontDesk","description":"Gruppo di Test","user_admin_id":1},
        {"name":"HR","description":"Gruppo Funzionale","user_admin_id":1},
        {"name":"Research and Development","description":"Gruppo Test","user_admin_id":1},
        {"name":"DevOps","description":"Gruppo Funzionale","user_admin_id":1},
        {"name":"IT Guys","description":"Gruppo Funzionale","user_admin_id":1},
        {"name":"Sales","description":"Gruppo di Test","user_admin_id":1},
        {"name":"Business Analyst","description":"Gruppo di Test","user_admin_id":1},
        {"name":"Business Development","description":"Gruppo Funzionale","user_admin_id":1},
        {"name":"Amministration","description":"Gruppo Test","user_admin_id":1},
        {"name":"Legal","description":"Gruppo Funzionale","user_admin_id":1}]';







    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $userList = json_decode($this->userSeed, true);
        foreach ($userList as $key => $user) {
            \App\Models\User::factory()->create(
                [
                    "name" => $user["name"],
                    "last_name" => $user["last_name"],
                    "email" => $user["email"],
                    "password" => Hash::make('Password01!'),
                    "is_admin" => $user["is_admin"],
                    "is_active" => $user["is_active"],
                ]
            );
        }

        $groupList = json_decode($this->groupSeed, true);
        foreach ($groupList as $key => $group) {
            \App\Models\GroupModel::factory()->create([
                "name" => $group["name"],
                "description" => $group["description"],
                "user_admin_id" => $group["user_admin_id"]
            ]);
        }


        \App\Models\Category::factory()->create(
            [
                "name" => "Intranet Application Error",
                "description" => "Error in the company intranet applications"
            ]
        );

        \App\Models\Category::factory()->create(
            [
                "name" => "Intranet General Error",
                "description" => "Error in the company intranet"
            ]
        );

        \App\Models\Category::factory()->create(
            [
                "name" => "Internal Mail",
                "description" => "General Error with the mail"
            ]
        );

        \App\Models\Category::factory()->create(
            [
                "name" => "Customer Problem",
                "description" => "Problems with a customer"
            ]
        );

        // Lo tratteremo allo stile italiano
        \App\Models\Category::factory()->create(
            [
                "name" => "Bill not payed",
                "description" => "A customer doesn't want to pay a bill"
            ]
        );

    }
}
