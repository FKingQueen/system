<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barangay;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barangay::truncate();

        $barangays =  [
            [
                'name' => 'Alay-Nangbabaan (Alay 15-B)',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Alogoog',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Ar-arusip',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Aring',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Balbaldez',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Bato',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Camanga',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Canaan',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Caraitan',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Gabut Norte',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Gabut Sur',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Garreta Poblacion',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Labut',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Lacuben',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Lubigan',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Mabusag Norte',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Mabusag Sur',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Madupayas',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Morong',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Nagrebcan',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Napu',
                'municipality_id' => '1',
            ],
            [
                'name' => 'La Virgen Milagrosa (Paguetpet)',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Pagsanahan Norte',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Pagsanahan Sur',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Paltit',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Parang',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Pasuc',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Santa Cruz Norte',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Santa Cruz Sur',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Saud',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Turod',
                'municipality_id' => '1',
            ],
            [
                'name' => 'Balioeg',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Bangsar',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Barbarangay',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Bomitog',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Bugasi',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Caestebanan',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Caribquib',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Catagtaguen',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Crispina',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Hilario Poblacion',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Imelda',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Lorenzo Poblacion',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Macayepyep',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Marcos Poblacion',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Nagpatayan',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Valdez',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Sinamar',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Tabtabagan',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Valenciano Poblacion',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Binacag',
                'municipality_id' => '2',
            ],
            [
                'name' => 'Aglipay (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Baay',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Baligat',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Bungon',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Baoa East',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Baoa West',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Barani (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Ben-agan (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Bil-loca',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Biningan',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Callaguip (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Camandingan',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Camguidan',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Cangrunaan (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Capacuan',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Caunayan (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Valdez Pob. (Caoayan)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Colo',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Pimentel (Cubol)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Dariwdiw 1,863',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Acosta Pob. (Iloilo)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Ablan Pob. (Labucao)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Lacub (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Mabaleng',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Magnuang',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Maipalig',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Nagbacalan',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Naguirangan',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Ricarte Pob. (Nalasin)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Palongpong',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Palpalicong (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Parangopong',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Payao',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Quiling Norte',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Quiling Sur',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Quiom',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Rayuray',
                'municipality_id' => '3',
            ],
            [
                'name' => 'San Julian (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'San Mateo',
                'municipality_id' => '3',
            ],
            [
                'name' => 'San Pedro',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Suabit (Pob.)',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Sumader',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Tabug',
                'municipality_id' => '3',
            ],
            [
                'name' => 'Anggapang Norte',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Anggapang Sur',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Bimmanga',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Cabuusan',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Comcomloong',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Gaang',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Lang-ayan-Baramban',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Lioes',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Maglaoi Centro',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Maglaoi Norte',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Maglaoi Sur',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Paguludan-Salindeg',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Pangil',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Pias Norte',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Pias Sur',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Poblacion I',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Poblacion II',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Salugan',
                'municipality_id' => '4',
            ],
            [
                'name' => 'San Simeon',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Santa Cruz',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Tapao-Tigue',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Torre',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Victoria',
                'municipality_id' => '4',
            ],
            [
                'name' => 'Albano (Pob.)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Bacsil',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Bagut',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Parado (Bangay)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Baresbes',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Barong',
                'municipality_id' => '5',
            ],[
                'name' => 'Bungcag',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Cali',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Capasan',
                'municipality_id' => '5',
            ],[
                'name' => 'Dancel (Pob.)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Foz',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Guerrero (Pob.)',
                'municipality_id' => '5',
            ],[
                'name' => 'Lanas',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Lumbad',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Madamba (Pob.)',
                'municipality_id' => '5',
            ],[
                'name' => 'Mandaloque',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Medina',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Ver (Naglayaan)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'San Marcelino (Padong)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Puruganan (Pob.)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Peralta (Pob.)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Root (Baldias)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Sagpatan',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Saludares',
                'municipality_id' => '5',
            ],
            [
                'name' => 'San Esteban',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Espiritu',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Sulquiano (Sidiran)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'San Francisco (Surrate)',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Suyo',
                'municipality_id' => '5',
            ],
            [
                'name' => 'San Marcos',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Elizabeth',
                'municipality_id' => '5',
            ],
            [
                'name' => 'Pacifico (Agunit)',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Imelda (Capariaan)',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Elizabeth (Culao)',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Daquioag',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Escoda',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Ferdinand',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Fortuna',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Lydia (Pob.)',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Mabuti',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Valdez (Biding)',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Tabucbuc (Ragas)',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Santiago',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Cacafean',
                'municipality_id' => '6',
            ],
            [
                'name' => 'Acnam',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Barangobong',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Barikir',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Bugayong',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Cabittauran',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Caray',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Garnaden',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Naguillan (Pagpag-ong)',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Poblacion',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Santo Niño',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Uguis',
                'municipality_id' => '7',
            ],
            [
                'name' => 'Bacsil',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Cabagoan',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Cabangaran',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Callaguip',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Cayubog',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Dolores',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Laoa',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Masintoc',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Monte',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Mumulaan',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Nagbacalan',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Nalasin',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Nanguyudan',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Oaig-Upay-Abulao',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Pambaran',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Pannaratan (Pob.)',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Paratong',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Pasil',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Salbang (Pob.)',
                'municipality_id' => '8',
            ],
            [
                'name' => 'San Agustin',
                'municipality_id' => '8',
            ],
            [
                'name' => 'San Blas (Pob.)',
                'municipality_id' => '8',
            ],
            [
                'name' => 'San Juan',
                'municipality_id' => '8',
            ],
            [
                'name' => 'San Pedro',
                'municipality_id' => '8',
            ],
            [
                'name' => 'San Roque (Pob.)',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Sangladan Pob. (Nalbuan)',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Santa Rita (Pob.)',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Sideg',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Suba',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Sungadan',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Surgui',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Veronica',
                'municipality_id' => '8',
            ],
            [
                'name' => 'Aglipay',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Apatut-Lubong',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Badio',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Barbar',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Buanga',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Bulbulala',
                'municipality_id' => '9',
            ],
            [
                'name' => 'BungrPo',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Cabaroan',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Capangdanan',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Dalayap',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Darat',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Gulpeng',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Liliputen',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Lumbaan-Bicbica',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Nagtrigoan',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Pagdilao (Pob.)',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Pugaoan',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Puritac',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Sacritan',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Salanap',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Santo Tomas',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Tartarabang',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Puzol',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Upon',
                'municipality_id' => '9',
            ],
            [
                'name' => 'Valbuena (Pob.)',
                'municipality_id' => '9',
            ],



            [
                'name' => 'San Agustin',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Bugnay',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Baltazar',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Bartolome',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Cayetano',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Eugenio',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Fernando',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Francisco',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Gregorio',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Guillermo',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Catuguing',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Ildefonso',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Jose',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Juan Bautista',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Lucas',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Marcos',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Miguel',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Pablo',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Paulo',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Pedro',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Lorenzo',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Santa Monica',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Nagrebcan',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Santa Cecilia',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Barabar',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Santa Asuncion',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Samac',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Silvestre',
                'municipality_id' => '10',
            ],
            [
                'name' => 'San Rufino',
                'municipality_id' => '10',
            ],
            [
                'name' => 'Payas',
                'municipality_id' => '10',
            ],

            [
                'name' => 'Aguitap',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Bagbag',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Bagbago',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Barcelona',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Bubuos',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Capurictan',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Catangraran',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Darasdas',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Juan (Pob.)',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Laureta (Pob.) ',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Lipay',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Maananteng',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Manalpac',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Mariquet',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Nagpatpatan',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Nalasin',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Puttao',
                'municipality_id' => '11',
            ],
            [
                'name' => 'San Juan',
                'municipality_id' => '11',
            ],
            [
                'name' => 'San Julian',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Santa Ana',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Santiago',
                'municipality_id' => '11',
            ],
            [
                'name' => 'Talugtog',
                'municipality_id' => '11',
            ],
          ];

        Barangay::insert( $barangays);
    }
}
