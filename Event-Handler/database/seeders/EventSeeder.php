<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('events')->count() == 0) {
            DB::table('events')->insert([
                [
                    'name' => 'MACSKAFOGÓ Film in Concert',
                    'creator_id' => 1,
                    'date' => '2025-01-25',
                    'location' => 'Szeged - Vaszy Viktor Tér 3.',
                    'picture' => '1130194010.jpg',
                    'type' => 'public',
                    'description' => 'Az előadás egy lélegzetelállító varázsvilágába kalauzolja nézőit, ahol a mesés interaktív darab keretein belül, bámulatos varázslatok részesei lehetnek.',
                ],
                [
                    'name' => 'Kulka',
                    'creator_id' => 1,
                    'date' => '2025-01-21',
                    'location' => 'Szeged, Szent-Györgyi Albert Agóra, Jósika utca 23',
                    'picture' => '189251219.png',
                    'type' => 'public',
                    'description' => 'Beszélgetés és könyvbemutató Kulka Jánossal és vendégeivel. A beszélgetést Gyárfás Dorka, a könyv szerzője vezeti.',
                ],
                [
                    'name' => 'Moliere: Tartuffe - a Genéziusz Színház előadása',
                    'creator_id' => 2,
                    'date' => '2025-01-21',
                    'location' => 'Szeged, Dugonics Tér 2.',
                    'picture' => '100762855.png',
                    'type' => 'public',
                    'description' => 'Orgon, egy jómódú francia polgár, akinek otthonába befurakodik egy látszólag mélyen vallásos „vendég”, Tartuffe. A ház „ura” és annak édesanyja teljes befolyása alá kerül, tisztelettel és imádattal tekintenek rá. Ám a család többi tagja koránt sincs elraggadtatva Orgon újdonsült barátjától, hamar átlátnak Tartuffe cselszövésein, de Orgont és anyját nem tudják meggyőzni arról, hogy a férfi egy csaló.',
                ],
                [
                    'name' => 'HONEYBEAST / SZEGED, CINEMA TRIP (zenés utazás 3D-ben)',
                    'creator_id' => 3,
                    'date' => '2025-02-16',
                    'location' => 'Szegedi Nemzeti Színház, Stefánia 5',
                    'picture' => '293450836.jpg',
                    'type' => 'public',
                    'description' => 'A Cinematrip olyan utazást ígér, amely minden érzékszervünkre egyszerre hat: a Legnagyobb hős az Így játszom és a többi jól ismert Honeybeast dal szereplői, akiknek magányaikban, szerelmeikben, félelmeikben és örömeikben oly gyakran magunkra ismerünk, most életre kelnek és olyan csodás helyszínekre visznek, amelyben közel két óra alatt járjuk be közös élményeink univerzumait, a római Colosseumtól az erdélyi viskóig, Portugáliától egészen az Androméda-köd spirálgalaxisáig. A felkészülés megkezdődött, az utazás február 16-án, 19h-kor indul a szegedi Nemzeti Színházban.',
                ],
                [
                    'name' => 'Szegedi Kortárs Balett: Diótörő',
                    'creator_id' => 1,
                    'date' => '2025-01-30',
                    'location' => 'Szegedi Nemzeti Színház, Stefánia 5',
                    'picture' => '1029056927.jpg',
                    'type' => 'public',
                    'description' => 'A Diótörő balett ötlete a cári színház egykori igazgatójától származott. E. T. A. Hoffmann: A diótörő és az egérkirály című meséje alapján olyan mese-balettet akart színpadra vinni, ami minden addigit felülmúl, mind hangzásban, mind pedig látványban. Csajkovszkijt kérte fel a muzsika megkomponálására. A hattyúk tava és a Csipkerózsika után harmadik, egyben utolsó balettje is nagy sikert hozott a szerzőnek. A Diótörő zenéjéből előbb a hat tételes szvit került bemutatásra 1892. márciusában, majd ugyanezen év decemberében bemutatták a pompásan kiállított színpadi művet is. A Diótörő a balett irodalom leggyakrabban játszott darabja lett.
Karácsony este a szülők díszítik a szalonban felállított hatalmas fát. A testvérek, Marika és Frici civakodása még a fa körül sem szűnik meg. Sorra érkeznek a meghívott gyerekek, barátságok kötődnek, a fiúk borsot törnek a kis lányok orra alá. Megkezdődik az ajándékok átadása. Rengeteg kedves játék, mesefigura, báb van a fa alatt levő díszes dobozokban. Késve betoppan a gyerekek mókás keresztapja, Drosselmeyer bácsi, aki különleges, felújított játékokat hozott a zsákjában. Marikának megtetszik egy régi diótörő báb. A kislány az este izgalmai után új játékát ölelve alszik el a karácsonyfa alatt. Álmában megelevenednek a nemrég átélt események képei, a bábok, a játékok életre kelnek, majd a szobát egerek népesítik be, élükön a gonosz Egérkirállyal. Diótörő herceg és barátai segítenek a lánynak, majd a hópihék országa után Tortavárba jutnak, ahol Cukorszilva tündér és Sütiséf úr a cukrász csapatával újabb és újabb csodás helyekre kalauzolja őket a varázslatos mesevilágban. Megindul a kalandok sorozata. Marika álmában, mint Mária hercegnő táncol Diótörő herceggel. A kislány hol félelmetes, hol csodálatos álmai jelennek meg a történetben, melynek végén újra együtt öleli egymást a család karácsony este.',
                ],
                [
                    'name' => 'Agykontroll tanfolyam gyerekeknek 2025',
                    'creator_id' => 1,
                    'date' => '2025-02-02',
                    'location' => 'Budapest XVI. kerület',
                    'picture' => '1250953685.png',
                    'type' => 'public',
                    'description' => 'A tanfolyam hatására a gyerek várhatóan magabiztosabb lesz, eredményesebben tud tanulni, képes megszüntetni fájdalmai zömét, betegség esetén gyorsabban meggyógyul, megtanulja céljait elérni, képes lesz megszabadulni rossz szokásaitól, képes jobb döntéseket hozni, nyugodtabb és energikusabb lesz. Ma már bizonyított tény, hogy képzeletünkkel hatni tudunk testünkre gondolataink erejét, energiáját felhasználva.',
                ],
            ]);
        }
    }
}
