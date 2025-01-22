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
                    'name' => 'Harry Potter - Mesés-Interaktív CosplayShow - Igazi varázslatokkal',
                    'creator_id'=>2,
                    'date' => '2025-01-25',
                    'location' => 'Szeged - Vaszy Viktor Tér 3.',
                    'picture' => 'https://cdn-az.allevents.in/events7/banners/5148d6a44d27afd47fe637effe39d21aed8448bd34ef4fe3d109c3f0af7be4a4-rimg-w1200-h628-dc020404-gmir?v=1737313610',
                    'type' => 'public',
                    'description' => 'Az előadás egy lélegzetelállító varázsvilágába kalauzolja nézőit, ahol a mesés interaktív darab keretein belül, bámulatos varázslatok részesei lehetnek.',
                ],
                [
                    'name' => 'MACSKAFOGÓ Film in Concert',
                    'creator_id'=>1,
                    'date' => '2025-01-25',
                    'location' => 'Szeged - Vaszy Viktor Tér 3.',
                    'picture' => 'https://cdn-az.allevents.in/events5/banners/1415395727fe06754563472c4d45bb687d44a63b10c41d7d8e61a583e185187e-rimg-w1200-h628-dc2a2a49-gmir?v=1737199535',
                    'type' => 'public',
                    'description' => 'Az előadás egy lélegzetelállító varázsvilágába kalauzolja nézőit, ahol a mesés interaktív darab keretein belül, bámulatos varázslatok részesei lehetnek.',
                ],
                [
                    'name' => 'Kulka',
                    'creator_id'=>1,
                    'date' => '2025-01-21',
                    'location' => 'Szeged, Szent-Györgyi Albert Agóra, Jósika utca 23',
                    'picture' => 'https://cdn-az.allevents.in/events4/banners/ab00031d7b1ebdcb91c0c96bf705740cf63b93717a4960bfd705d5095ec1570c-rimg-w1200-h675-dca5827c-gmir?v=1733827334',
                    'type' => 'public',
                    'description' => 'Beszélgetés és könyvbemutató Kulka Jánossal és vendégeivel. A beszélgetést Gyárfás Dorka, a könyv szerzője vezeti.',
                ],
                [
                    'name' => 'Moliere: Tartuffe - a Genéziusz Színház előadása',
                    'creator_id'=>2,
                    'date' => '2025-01-21',
                    'location' => 'Szeged, Dugonics Tér 2.',
                    'picture' => 'https://cdn-az.allevents.in/events4/banners/a85324ce5ca8bc61ff6d4ee5f11ed029acd79b0dc93b96ca45bd28c120ddbc5f-rimg-w1080-h1528-dc010101-gmir?v=1737405354',
                    'type' => 'public',
                    'description' => 'Orgon, egy jómódú francia polgár, akinek otthonába befurakodik egy látszólag mélyen vallásos „vendég”, Tartuffe. A ház „ura” és annak édesanyja teljes befolyása alá kerül, tisztelettel és imádattal tekintenek rá. Ám a család többi tagja koránt sincs elraggadtatva Orgon újdonsült barátjától, hamar átlátnak Tartuffe cselszövésein, de Orgont és anyját nem tudják meggyőzni arról, hogy a férfi egy csaló.',
                ],
                [
                    'name' => 'HONEYBEAST / SZEGED, CINEMA TRIP (zenés utazás 3D-ben)',
                    'creator_id'=>3,
                    'date' => '2025-02-16',
                    'location' => 'Szegedi Nemzeti Színház, Stefánia 5',
                    'picture' => 'https://cdn-az.allevents.in/events5/banners/89de113368210666b2bc23d73df7c646e9024eb513933b53e4591c1a8d37e63a-rimg-w1200-h628-dc14101c-gmir?v=1737474887',
                    'type' => 'public',
                    'description' => 'A Cinematrip olyan utazást ígér, amely minden érzékszervünkre egyszerre hat: a Legnagyobb hős az Így játszom és a többi jól ismert Honeybeast dal szereplői, akiknek magányaikban, szerelmeikben, félelmeikben és örömeikben oly gyakran magunkra ismerünk, most életre kelnek és olyan csodás helyszínekre visznek, amelyben közel két óra alatt járjuk be közös élményeink univerzumait, a római Colosseumtól az erdélyi viskóig, Portugáliától egészen az Androméda-köd spirálgalaxisáig. A felkészülés megkezdődött, az utazás február 16-án, 19h-kor indul a szegedi Nemzeti Színházban.',
                ],
                
            ]);
        }
    }
}
