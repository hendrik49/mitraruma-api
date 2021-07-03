<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsAreaCoverageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = json_decode($this->value);
        DB::table('wp_cms')->where('name', 'area-coverage')->update(
            ['value' => json_encode($value)]);
    }

    private $value = '[{
			"title": "Aceh",
			"child": [
				"Kota Banda Aceh",
				"Kota Sabang",
				"Kota Lhokseumawe",
				"Kota Langsa",
				"Kota Subulussalam",
				"Kab. Aceh Selatan",
				"Kab. Aceh Tenggara",
				"Kab. Aceh Timur",
				"Kab. Aceh Tengah",
				"Kab. Aceh Barat",
				"Kab. Aceh Besar",
				"Kab. Pidie",
				"Kab. Aceh Utara",
				"Kab. Simeulue",
				"Kab. Aceh Singkil",
				"Kab. Bireun",
				"Kab. Aceh Barat Daya",
				"Kab. Gayo Lues",
				"Kab. Aceh Jaya",
				"Kab. Nagan Raya",
				"Kab. Aceh Tamiang",
				"Kab. Bener Meriah",
				"Kab. Pidie Jaya"
			]
		},
		{
			"title": "Sumatera Utara",
			"child": [
				"Kota Medan",
				"Kota Pematang Siantar",
				"Kota Sibolga",
				"Kota Tanjung Balai",
				"Kota Binjai",
				"Kota Tebing Tinggi",
				"Kota Padang Sidempuan",
				"Kota Gunung Sitoli",
				"Kab. Serdang Bedagai",
				"Kab. Samosir",
				"Kab. Humbang Hasundutan",
				"Kab. Pakpak Bharat",
				"Kab. Nias Selatan",
				"Kab. Mandailing Natal",
				"Kab. Toba Samosir",
				"Kab. Dairi",
				"Kab. Labuhan Batu",
				"Kab. Asahan",
				"Kab. Simalungun",
				"Kab. Deli Serdang",
				"Kab. Karo",
				"Kab. Langkat",
				"Kab. Nias",
				"Kab. Tapanuli Selatan",
				"Kab. Tapanuli Utara",
				"Kab. Tapanuli Tengah",
				"Kab. Batu Bara",
				"Kab. Padang Lawas Utara",
				"Kab. Padang Lawas",
				"Kab. Labuhanbatu Selatan",
				"Kab. Labuhanbatu Utara",
				"Kab. Nias Utara",
				"Kab. Nias Barat"
			]
		},
		{
			"title": "Sumatera Barat",
			"child": [
				"Kota Padang",
				"Kota Solok",
				"Kota Sawhlunto",
				"Kota Padang Panjang",
				"Kota Bukittinggi",
				"Kota Payakumbuh",
				"Kota Pariaman",
				"Kab. Pasaman Barat",
				"Kab. Solok Selatan",
				"Kab. Dharmasraya",
				"Kab. Kepulauan Mentawai",
				"Kab. Pasaman",
				"Kab. Lima Puluh Kota",
				"Kab. Agam",
				"Kab. Padang Pariaman",
				"Kab. Tanah Datar",
				"Kab. Sijunjung",
				"Kab. Solok",
				"Kab. Pesisir Selatan"
			]
		},
		{
			"title": "Riau",
			"child": [
				"Kota Pekan Baru",
				"Kota Dumai",
				"Kab. Kepulauan Meranti",
				"Kab. Kuantan Singingi",
				"Kab. Siak",
				"Kab. Rokan Hilir",
				"Kab. Rokan Hulu",
				"Kab. Pelalawan",
				"Kab. Indragiri Hilir",
				"Kab. Bengkalis",
				"Kab. Indragiri Hulu",
				"Kab. Kampar"
			]
		},
		{
			"title": "Jambi",
			"child": [
				"Kota Jambi",
				"Kota Sungai Penuh",
				"Kab. Tebo",
				"Kab. Bungo",
				"Kab. Tanjung Jabung Timur",
				"Kab. Tanjung Jabung Barat",
				"Kab. Muaro Jambi",
				"Kab. Batanghari",
				"Kab. Sarolangun",
				"Kab. Merangin",
				"Kab. Kerinci"
			]
		},
		{
			"title": "Sumatera Selatan",
			"child": [
				"Kota Palembang",
				"Kota Pagar Alam",
				"Kota Lubuk Linggau",
				"Kota Prabumulih",
				"Kab. Musi Rawas Utara",
				"Kab. Penukal Abab Lematang Ilir",
				"Kab. Empat Lawang",
				"Kab. Ogan Ilir",
				"Kab. Ogan Komering Ulu Selatan",
				"Kab. Ogan Komering Ulu Timur",
				"Kab. Banyuasin",
				"Kab. Musi Banyuasin",
				"Kab. Musi Rawas",
				"Kab. Lahat",
				"Kab. Muara Enim",
				"Kab. Ogan Komering Ilir",
				"Kab. Ogan Komering Ulu"
			]
		},
		{
			"title": "Bengkulu",
			"child": [
				"Kota Bengkulu",
				"Kab. Bengkulu Tengah",
				"Kab. Kepahiang",
				"Kab. Lebong",
				"Kab. Muko Muko",
				"Kab. Seluma",
				"Kab. Kaur",
				"Kab. Bengkulu Utara",
				"Kab. Rejang Lebong",
				"Kab. Bengkulu Selatan"
			]
		},
		{
			"title": "Lampung",
			"child": [
				"Kota Bandar Lampung",
				"Kota Metro",
				"Kab. Pesisir Barat",
				"Kab. Tulangbawang Barat",
				"Kab. Mesuji",
				"Kab. Pringsewu",
				"Kab. Pesawaran",
				"Kab. Way Kanan",
				"Kab. Lampung Timur",
				"Kab. Tanggamus",
				"Kab. Tulang Bawang",
				"Kab. Lampung Barat",
				"Kab. Lampung Utara",
				"Kab. Lampung Tengah",
				"Kab. Lampung Selatan"
			]
		},
		{
			"title": "Kepulauan Bangka Belitung",
			"child": [
				"Kota Pangkal Pinang",
				"Kab. Belitung Timur",
				"Kab. Bangka Barat",
				"Kab. Bangka Tengah",
				"Kab. Bangka Selatan",
				"Kab. Belitung",
				"Kab. Bangka"
			]
		},
		{
			"title": "Kepulauan Riau",
			"child": [
				"Kota Batam",
				"Kota Tanjung Pinang",
				"Kab. Kepulauan Anambas",
				"Kab. Lingga",
				"Kab. Natuna",
				"Kab. Karimun",
				"Kab. Bintan"
			]
		},
		{
			"title": "DKI Jakarta",
			"child": [
				"Kota Jakarta Timur",
				"Kota Jakarta Selatan",
				"Kota Jakarta Barat",
				"Kota Jakarta Utara",
				"Kota Jakarta Pusat",
				"Kab. Kepulauan Seribu"
			]
		},
		{
			"title": "Jawa Barat",
			"child": [
				"Kota Bandung",
				"Kota Banjar",
				"Kota Tasikmalaya",
				"Kota Cimahi",
				"Kota Depok",
				"Kota Bekasi",
				"Kota Cirebon",
				"Kota Sukabumi",
				"Kota Bogor",
				"Kab. Pangandaran",
				"Kab. Bandung Barat",
				"Kab. Bekasi",
				"Kab. Karawang",
				"Kab. Purwakarta",
				"Kab. Subang",
				"Kab. Indramayu",
				"Kab. Sumedang",
				"Kab. Majalengka",
				"Kab. Cirebon",
				"Kab. Kuningan",
				"Kab. Ciamis",
				"Kab. Tasikmalaya",
				"Kab. Garut",
				"Kab. Bandung",
				"Kab. Cianjur",
				"Kab. Sukabumi",
				"Kab. Bogor"
			]
		},
		{
			"title": "Jawa Tengah",
			"child": [
				"Kota Semarang",
				"Kota Tegal",
				"Kota Pekalongan",
				"Kota Salatiga",
				"Kota Surakarta",
				"Kota Magelang",
				"Kab. Brebes",
				"Kab. Tegal",
				"Kab. Pemalang",
				"Kab. Pekalongan",
				"Kab. Batang",
				"Kab. Kendal",
				"Kab. Temanggung",
				"Kab. Semarang",
				"Kab. Demak",
				"Kab. Jepara",
				"Kab. Kudus",
				"Kab. Pati",
				"Kab. Rembang",
				"Kab. Blora",
				"Kab. Grobogan",
				"Kab. Sragen",
				"Kab. Karanganyar",
				"Kab. Wonogiri",
				"Kab. Sukoharjo",
				"Kab. Klaten",
				"Kab. Boyolali",
				"Kab. Magelang",
				"Kab. Wonosobo",
				"Kab. Purworejo",
				"Kab. Kebumen",
				"Kab. Banjarnegara",
				"Kab. Purbalingga",
				"Kab. Banyumas",
				"Kab. Cilacap"
			]
		},
		{
			"title": "DI Yogyakarta",
			"child": [
				"Kota Yogyakarta",
				"Kab. Sleman",
				"Kab. Gunung Kidul",
				"Kab. Bantul",
				"Kab. Kulon Progo"
			]
		},
		{
			"title": "Jawa Timur",
			"child": [
				"Kota Surabaya",
				"Kota Batu",
				"Kota Madiun",
				"Kota Mojokerto",
				"Kota Pasuruan",
				"Kota Probolinggo",
				"Kota Malang",
				"Kota Blitar",
				"Kota Kediri",
				"Kab. Sumenep",
				"Kab. Pamekasan",
				"Kab. Sampang",
				"Kab. Bangkalan",
				"Kab. Gresik",
				"Kab. Lamongan",
				"Kab. Tuban",
				"Kab. Bojonegoro",
				"Kab. Ngawi",
				"Kab. Magetan",
				"Kab. Madiun",
				"Kab. Nganjuk",
				"Kab. Jombang",
				"Kab. Mojokerto",
				"Kab. Sidoarjo",
				"Kab. Pasuruan",
				"Kab. Probolinggo",
				"Kab. Situbondo",
				"Kab. Bondowoso",
				"Kab. Banyuwangi",
				"Kab. Jember",
				"Kab. Lumajang",
				"Kab. Malang",
				"Kab. Kediri",
				"Kab. Blitar",
				"Kab. Tulungagung",
				"Kab. Trenggalek",
				"Kab. Ponorogo",
				"Kab. Pacitan"
			]
		},
		{
			"title": "Banten",
			"child": [
				"Kota Serang",
				"Kota Cilegon",
				"Kota Tangerang",
				"Kota Tangerang Selatan",
				"Kab. Serang",
				"Kab. Tangerang",
				"Kab. Lebak",
				"Kab. Pandeglang"
			]
		},
		{
			"title": "Bali",
			"child": [
				"Kota Denpasar",
				"Kab. Buleleng",
				"Kab. Karangasem",
				"Kab. Bangli",
				"Kab. Klungkung",
				"Kab. Gianyar",
				"Kab. Badung",
				"Kab. Tabanan",
				"Kab. Jembrana"
			]
		},
		{
			"title": "Nusa Tenggara Barat",
			"child": [
				"Kota Mataram",
				"Kota Bima",
				"Kab. Lombok Utara",
				"Kab. Sumbawa Barat",
				"Kab. Bima",
				"Kab. Dompu",
				"Kab. Sumbawa",
				"Kab. Lombok Timur",
				"Kab. Lombok Tengah",
				"Kab. Lombok Barat"
			]
		},
		{
			"title": "Nusa Tenggara Timur",
			"child": [
				"Kota Kupang",
				"Kab. Malaka",
				"Kab. Sabu Raijua",
				"Kab. Manggarai Timur",
				"Kab. Sumba Barat Daya",
				"Kab. Sumba Tengah",
				"Kab. Nagekeo",
				"Kab. Manggarai Barat",
				"Kab. Rote Ndao",
				"Kab. Lembata",
				"Kab. Sumba Barat",
				"Kab. Sumba Timur",
				"Kab. Manggarai",
				"Kab. Ngada",
				"Kab. Ende",
				"Kab. Sikka",
				"Kab. Flores Timur",
				"Kab. Alor",
				"Kab. Belu",
				"Kab. Timor Tengah Utara",
				"Kab. Timor Tengah Selatan",
				"Kab. Kupang"
			]
		},
		{
			"title": "Kalimantan Barat",
			"child": [
				"Kota Pontianak",
				"Kota Singkawang",
				"Kab. Kubu Raya",
				"Kab. Kayong Utara",
				"Kab. Sekadau",
				"Kab. Melawi",
				"Kab. Landak",
				"Kab. Bengkayang",
				"Kab. Kapuas Hulu",
				"Kab. Sintang",
				"Kab. Ketapang",
				"Kab. Sanggau",
				"Kab. Mempawah",
				"Kab. Sambas"
			]
		},
		{
			"title": "Kalimantan Tengah",
			"child": [
				"Kota Palangkaraya",
				"Kab. Barito Timur",
				"Kab. Murung Raya",
				"Kab. Pulang Pisau",
				"Kab. Gunung Mas",
				"Kab. Lamandau",
				"Kab. Sukamara",
				"Kab. Seruyan",
				"Kab. Katingan",
				"Kab. Barito Utara",
				"Kab. Barito Selatan",
				"Kab. Kapuas",
				"Kab. Kotawaringin Timur",
				"Kab. Kotawaringin Barat"
			]
		},
		{
			"title": "Kalimantan Selatan",
			"child": [
				"Kota Banjarmasin",
				"Kota Banjarbaru",
				"Kab. Balangan",
				"Kab. Tanah Bambu",
				"Kab. Tabalong",
				"Kab. Hulu Sungai Utara",
				"Kab. Hulu Sungai Tengah",
				"Kab. Hulu Sungai Selatan",
				"Kab. Tapin",
				"Kab. Barito Kuala",
				"Kab. Banjar",
				"Kab. Kotabaru",
				"Kab. Tanah Laut"
			]
		},
		{
			"title": "Kalimantan Timur",
			"child": [
				"Kota Samarinda",
				"Kota Bontang",
				"Kota Balikpapan",
				"Kab. Mahakam Ulu",
				"Kab. Penajam Paser Utara",
				"Kab. Kutai Timur",
				"Kab. Kutai Barat",
				"Kab. Berau",
				"Kab. Kutai Kertanegara",
				"Kab. Paser"
			]
		},
		{
			"title": "Kalimantan Utara",
			"child": [
				"Kota Tarakan",
				"Kab. Tana Tidung",
				"Kab. Nunukan",
				"Kab. Malinau",
				"Kab. Bulungan"
			]
		},
		{
			"title": "Sulawesi Utara",
			"child": [
				"Kota Manado",
				"Kota Tomohon",
				"Kota Bitung",
				"Kota Kotamobagu",
				"Kab. Bolaang Mangondow Selatan",
				"Kab. Bolaang Mangondow Timur",
				"Kab. Kepulauan Siau Tagulandang Biaro",
				"Kab. Bolaang Mangondow Utara",
				"Kab. Minahasa Tenggara",
				"Kab. Minahasa Utara",
				"Kab. Minahasa Selatan",
				"Kab. Kepulauan Talaud",
				"Kab. Kepulauan Sangihe",
				"Kab. Minahasa",
				"Kab. Bolaang Mangondow"
			]
		},
		{
			"title": "Sulawesi Tengah",
			"child": [
				"Kota Palu",
				"Kab. Morowali Utara",
				"Kab. Banggai Laut",
				"Kab. Sigi",
				"Kab. Tojo Una-Una",
				"Kab. Parigi Moutong",
				"Kab. Banggai Kepulauan",
				"Kab. Morowali",
				"Kab. Buol",
				"Kab. Toli-Toli",
				"Kab. Donggala",
				"Kab. Poso",
				"Kab. Banggai"
			]
		},
		{
			"title": "Sulawesi Selatan",
			"child": [
				"Kota Makasar",
				"Kota Palopo",
				"Kota Pare Pare",
				"Kab. Toraja Utara",
				"Kab. Luwu Timur",
				"Kab. Luwu Utara",
				"Kab. Tana Toraja",
				"Kab. Luwu",
				"Kab. Enrekang",
				"Kab. Pinrang",
				"Kab. Sidenreng Rappang",
				"Kab. Wajo",
				"Kab. Soppeng",
				"Kab. Barru",
				"Kab. Pangkajene Kepulauan",
				"Kab. Maros",
				"Kab. Bone",
				"Kab. Sinjai",
				"Kab. Gowa",
				"Kab. Takalar",
				"Kab. Jeneponto",
				"Kab. Bantaeng",
				"Kab. Bulukumba",
				"Kab. Kepulauan Selayar"
			]
		},
		{
			"title": "Sulawesi Tenggara",
			"child": [
				"Kota Kendari",
				"Kota Bau Bau",
				"Kab. Buton Selatan",
				"Kab. Buton Tengah",
				"Kab. Muna Barat",
				"Kab. Konawe Kepulauan",
				"Kab. Kolaka Timur",
				"Kab. Buton Utara",
				"Kab. Konawe Utara",
				"Kab. Kolaka Utara",
				"Kab. Wakatobi",
				"Kab. Bombana",
				"Kab. Konawe Selatan",
				"Kab. Buton",
				"Kab. Muna",
				"Kab. Konawe",
				"Kab. Kolaka"
			]
		},
		{
			"title": "Gorontalo",
			"child": [
				"Kota Gorontalo",
				"Kab. Pohuwato",
				"Kab. Bone Bolango",
				"Kab. Boalemo",
				"Kab. Gorontalo",
				"Kab. Gorontalo Utara"
			]
		},
		{
			"title": "Sulawesi Barat",
			"child": [
				"Kab. Majene",
				"Kab. Polowali Mandar",
				"Kab. Mamasa",
				"Kab. Mamuju",
				"Kab. Mamuju Utara",
				"Kab. Mamuju Tengah"
			]
		},
		{
			"title": "Maluku",
			"child": [
				"Kota Ambon",
				"Kota Tual",
				"Kab. Buru Selatan",
				"Kab. Maluku Barat Daya",
				"Kab. Kepulauan Aru",
				"Kab. Seram Bagian Barat",
				"Kab. Seram Bagian Timur",
				"Kab. Buru",
				"Kab. Maluku Tenggara Barat",
				"Kab. Maluku Tenggara",
				"Kab. Maluku Tengah"
			]
		},
		{
			"title": "Maluku Utara",
			"child": [
				"Kota Ternate",
				"Kota Tidore Kepulauan",
				"Kab. Pulau Taliabu",
				"Kab. Pulau Morotai",
				"Kab. Halmahera Timur",
				"Kab. Kepulauan Sula",
				"Kab. Halmahera Selatan",
				"Kab. Halmahera Utara",
				"Kab. Halmahera Tengah",
				"Kab. Halmahera Barat"
			]
		},
		{
			"title": "Papua",
			"child": [
				"Kota Jayapura",
				"Kab. Deiyai",
				"Kab. Intan Jaya",
				"Kab. Dogiyai",
				"Kab. Puncak",
				"Kab. Nduga",
				"Kab. Lanny Jaya",
				"Kab. Yalimo",
				"Kab. Mamberamo Tengah",
				"Kab. Mamberamo Raya",
				"Kab. Supiori",
				"Kab. Asmat",
				"Kab. Mappi",
				"Kab. Boven Digoel",
				"Kab. Waropen",
				"Kab. Tolikara",
				"Kab. Yahukimo",
				"Kab. Pegunungan Bintang",
				"Kab. Keerom",
				"Kab. Sarmi",
				"Kab. Mimika",
				"Kab. Paniai",
				"Kab. Puncak Jaya",
				"Kab. Biak Numfor",
				"Kab. Kepulauan Yapen",
				"Kab. Nabire",
				"Kab. Jayapura",
				"Kab. Jayawijaya",
				"Kab. Merauke"
			]
		},
		{
			"title": "Papua Barat",
			"child": [
				"Kota Sorong",
				"Kab. Pegunungan Arfak",
				"Kab. Manokwari Selatan",
				"Kab. Maybrat",
				"Kab. Tambrauw",
				"Kab. Kaimana",
				"Kab. Teluk Wondama",
				"Kab. Teluk Bintuni",
				"Kab. Raja Ampat",
				"Kab. Sorong Selatan",
				"Kab. Fak Fak",
				"Kab. Manokwari",
				"Kab. Sorong"
			]
		}
	]';

}
