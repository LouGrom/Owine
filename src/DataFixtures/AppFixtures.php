<?php

namespace App\DataFixtures;

use App\Entity\Appellation;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductBrand;
use App\Entity\Color;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Type;
use App\Entity\Company;
use App\Entity\Cart;
use App\Entity\Destination;
use App\Entity\Package;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Xvladqt\Faker\LoremFlickrProvider;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure la langue dans laquelle nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new LoremFlickrProvider($faker));


        // ----------------------------------------------------------- ProductBrand Random -----------------------------------------------------------------
        // On crée 4 marques
        $brand_name = ['La Romaneé Conti', 'Henri Ehrhart', 'Krug', 'Tiffon', 'Feun', 'La Brouette', 'Tati', 'Epic fail', 'Le Cep d’Argent', 'Damoiseau', 'Coureur des Bois'];
        for($i = 0; $i < count($brand_name); $i++){

            $brand = new ProductBrand();
            $brand->setName($brand_name[$i]);
            $brand->setSelectionFilter($i);
            $brand->setPicture($faker->imageUrl(200,200,['logo']));

            // Tableau des objets ProductBrand
            $brandList[$brand_name[$i]] = $brand;

            $manager->persist($brand);
        }


        // ----------------------------------------------------------- ProductCategory Random -----------------------------------------------------------------
        // On crée 4 categories
        $category_name = ['AOP', 'IGP', 'Vin de France'];
        for($i = 0; $i < count($category_name); $i++){

            $category = new ProductCategory();
            $category->setName($category_name[$i]);
            $category->setSelectionFilter($i);

            // Tableau des objets ProductCategory
            $categoryList[$category_name[$i]] = $category;

            $manager->persist($category);
        }

        // ----------------------------------------------------------- ProductType Random -----------------------------------------------------------------
        // On crée 4 Types
        $type_name = ['Tranquille', 'Effervescent', 'Liqueur', 'Spiritueux'];
        for($i = 0; $i < count($type_name); $i++){
            $type = new Type();
            $type->setName($type_name[$i]);

            // Tableau des objets ProductCategory
            $typeList[$type_name[$i]] = $type;
            $manager->persist($type);
        }

        // ----------------------------------------------------------- Color Random -----------------------------------------------------------------
        // On crée 5 couleurs
        $color_name = ['Rouge', 'Blanc', 'Rosé'];
        for($i = 0; $i < count($color_name); $i++){
            $color = new Color();
            $color->setName($color_name[$i]);

            // Tableau des objets ProductCategory
            $colorList[$color_name[$i]] = $color;
            $manager->persist($color);
        }


        // ----------------------------------------------------------- Appellation Random -----------------------------------------------------------------
        // On crée les appellations
        $appellation_name = ['Échézeaux', 'La Tâche', 'Montrachet', 'Champagne', 'Crémant d\'Alsace', 'Alsace Riesling', 'Alsace Pinot Gris', 'Alsace Pinot Noir', 'Cognac', 'Saint-Pourçain', 'Côtes de Provence', 'Calvados', 'Muscat de Rivesaltes', 'Vin de glace', 'Rhum', 'Crème d\'érable'];
        for($i = 0; $i < count($appellation_name); $i++){
            $appellation = new Appellation();
            $appellation->setName($appellation_name[$i]);

            // Tableau des objets appellation
            $appellationList[$appellation_name[$i]] = $appellation;
            $manager->persist($appellation);
        }
        // ----------------------------------------------------------- Destination -----------------------------------------------------------------

        $countryList= [
            'National' => [
                'France' => 'FR'
            ],
            'Europe' =>[
                'Allemagne' => 'DE',
                'Autriche' => 'AT',
                'Belgique' => 'BE',
                'Danemark' => 'DK',
                'Espagne' => 'ES',
                'Finlande' => 'FI',
                'Italie' => 'IT',
                'Pays-Bas' => 'NL',
                'Portugal' => 'PT',
                'Royaume-Uni' => 'GB',
                'Suède' => 'SE'
            ],
            'World' =>[
                'Australie' => 'AU',
                'Canada' => 'CA',
                'Chine' => 'CN',
                'Corée du Sud' => 'KR',
                'États-Unis' => 'US',
                'Israël' => 'IL',
                'Japon' => 'JP',
                'Norvège' => 'NO',
                'Russie' => 'RU',
                'Singapour' => 'SG',
                'Suisse' => 'CH',
                'Taïwan' => 'TW',
                'Vietnam' => 'VN'
            ]
        ];

        foreach($countryList as $region => $array) {

            foreach($array as $country => $iso) {

                $destination = new Destination();

                $destination->setZone($region);
                $destination->setCountry($country);
                $destination->setIso($iso);

                $destinationList[] = $destination;

                $manager->persist($destination);
                $manager->flush();
            }
        }

        // ------------------------------------------------- BOUTIQUES -----------------------------------------------
        
        $companyList = [
            [
                'name' => 'Domaine de la Romanée-Conti',
                'siret' => '778 269 407 00020',
                'vat' => 'FR 94 778269407',
                'picture' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/00/Domaine_de_la_Roman%C3%A9e-conti_02.jpg/800px-Domaine_de_la_Roman%C3%A9e-conti_02.jpg',
                'presentation' => "Le Domaine de la Romanée-Conti ou DRC est un des plus prestigieux domaines viticoles du monde avec 25,5 hectares en majeure partie à Vosne-Romanée sur la route des Grands Crus dans le vignoble de la côte de Nuits du vignoble de Bourgogne (baptisé du nom du clos de la Romanée-conti de 1,8 hectares, un des grands crus mythiques les plus prestigieux du monde). La société civile du même nom est fondée en 1942 par Edmond Gaudin de Villaine. Elle est cogérée à ce jour, pour leur famille héritière, par les viticulteurs co-héritiers Aubert de Villaine et Perrine Fenal.",
                'rate' => 3,
                'validated' => 1,
                'seller' => [
                    [
                        'firstname' => 'Aubert',
                        'lastname' => 'DE VILLAINE',
                        'email' => 'seller2@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Aubert',
                        'lastname' => 'DE VILLAINE',
                        'street' => '1 Place de l\'Église',
                        'city' => 'Vosne-Romanée',
                        'zipCode' => '21700',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '0102030405'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'La Tâche',
                        'price' => 3500,
                        'description' => "La Tâche est élégance et vigueur. Sous la fréquente fermeté des tannins, la passion brûle, maîtrisée par une implacable élégance de cour.",
                        'quantity' => 12,
                        'vintage' => '2011',
                        'alcoholVolume' => 13,
                        'brand' => 'La Romaneé Conti',
                        'color' => 'Rouge',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'picture' => 'https://avis-vin.lefigaro.fr/media/cache/bottle_fiche/var/src/104/25832-bouteille-domaine-de-la-romanee-conti-la-tache-rouge--la-tache.png',
                        'hsCode' => '2204.21.00',
                        'area' => 'Bourgogne',
                        'cuveeDomaine' => 'Domaine de la Romaneé Conti',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 2
                    ],
                
                    [
                        'appellation' => 'Échézeaux',
                        'price' => 1650,
                        'description' => "De tous les crus du Domaine, c'est le plus précoce, le moins complexe. Il s'épanouit avant les autres avec une ravissante clarté d'expression : une séduisante tendresse habille un squelette d'acier qui lui permet d'évoluer avec élégance. C'est le frère cadet du Grands-Echézeaux, glorieux aîné dont il brûle d'égaler la fortune. Il s'en approche parfois, parlant un langage musclé et conquérant.",
                        'quantity' => 6,
                        'vintage' => '2010',
                        'alcoholVolume' => 13.5,
                        'brand' => 'La Romaneé Conti',
                        'color' => 'Rouge',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'picture' => 'https://www.comptoirdesmillesimes.com/30562-pdt_540/echezeaux-grand-cru-2011-louis-latour.jpg',
                        'hsCode' => '2204.21.00',
                        'area' => 'Bourgogne',
                        'cuveeDomaine' => 'Domaine de la Romaneé Conti',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 2
                    ],
                    [
                        'appellation' => 'Montrachet',
                        'price' => 1650,
                        'description' => "Le vin de Montrachet est d'une complexité inégalée, son élégance et sa puissance en font un vin d'exception !",
                        'quantity' => 36,
                        'vintage' => '2011',
                        'brand' => 'La Romaneé Conti',
                        'color' => 'Rouge',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'alcoholVolume' => 13.5,
                        'picture' => 'https://www.vinatis.com/27659-detail_default/montrachet-grand-cru-2012-louis-latour.png',
                        'hsCode' => '2204.21.00',
                        'area' => 'Bourgogne',
                        'cuveeDomaine' => 'Domaine de la Romaneé Conti',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 2
                    ],  
                ]
            ],
            [
                'name' => 'Champagne Krug',
                'siret' => '335 580 296 00010',
                'vat' => 'FR 16 335580296',
                'picture' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Champagne_Krug_courtyard.jpg/1600px-Champagne_Krug_courtyard.jpg',
                'presentation' => "Le Champagne Krug est une maison de champagne basée à Reims depuis plus de cent soixante dix ans. La maison est fondée en 1843, par Johann-Joseph Krug, originaire de Mayence, alors sous administration française1. C'est une marque de la société MHCS (groupe LVMH).",
                'rate' => 4,
                'validated' => 1,
                'seller' => [
                    [
                        'firstname' => 'Maggie',
                        'lastname' => 'HENRIQUEZ',
                        'email' => 'seller1@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Maggie',
                        'lastname' => 'HENRIQUEZ',
                        'street' => '5 Rue Coquebert',
                        'city' => 'Reims',
                        'zipCode' => '51100',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '0102030405'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Champagne',
                        'price' => 165,
                        'description' => "Krug Grande Cuvée est l’emblématique signature de la maison Krug. Depuis 1843, Krug Grande Cuvée incarne ce que Joseph Krug, fondateur de la maison Krug, cherchait à offrir à ses clients : un Champagne d’une grande richesse et d’une fine élégance, au-delà des millésimes.",
                        'quantity' => 3600,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Krug',
                        'color' => 'Blanc',
                        'type' => 'Effervescent',
                        'category' => 'AOP',
                        'alcoholVolume' => 12,
                        'picture' => 'https://media.grandsbourgognes.com/3313-large_default/krug-grande-cuv%C3%A9e-167%C3%A8me-edition.jpg',
                        'hsCode' => '2204.10.00',
                        'area' => 'Champagne',
                        'cuveeDomaine' => 'Grande Cuvée',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 3
                    ],
                    [
                        'appellation' => 'Champagne',
                        'price' => 260,
                        'description' => "Krug Rosé est né du souhait de la Maison Krug d’offrir à ses amateurs sa vision du Champagne Rosé. C’est un Champagne inédit, à la création duquel préside la même philosophie que Krug Grande Cuvée, dépassant lui aussi la notion même de millésime. Krug Rosé est à la fois surprenant et audacieux. Il offre une palette aromatique aussi étendue qu’inhabituelle pour un Champagne Rosé.",
                        'quantity' => 3600,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Krug',
                        'color' => 'Rosé',
                        'type' => 'Effervescent',
                        'category' => 'AOP',
                        'alcoholVolume' => 12,
                        'picture' => 'https://media.grandsbourgognes.com/5852-large_default/krug-clos-du-mesnil.jpg',
                        'hsCode' => '2204.10.00',
                        'area' => 'Champagne',
                        'cuveeDomaine' => 'Clos du Mesnil',
                        'capacity' => 750,
                        'status' => 0,
                        'rate' => 4
                    ],
                    [
                        'appellation' => 'Champagne',
                        'price' => 2790,
                        'description' => "Le savoir-faire exceptionnel de la Maison Krug a révélé un Champagne rare, issu d’un terroir extraordinaire, le Clos d’Ambonnay. Cette minuscule parcelle close de 0,68 hectare est située au cœur du village d’Ambonnay, l’un des plus réputés pour ses Pinot Noirs en Champagne et le principal fournisseur de Pinot Noir depuis les premières années de la Maison.
                        Krug Clos d’Ambonnay est l’expression de la pureté d’un unique vignoble ceint de murs : le Clos d’Ambonnay dans le village d’Ambonnay, d’un seul cépage: le Pinot Noir et d’une seule année.",
                        'quantity' => 1800,
                        'vintage' => '1998',
                        'brand' => 'Krug',
                        'color' => 'Blanc',
                        'type' => 'Effervescent',
                        'category' => 'AOP',
                        'alcoholVolume' => 12,
                        'picture' => 'https://media.grandsbourgognes.com/8594-large_default/krug-clos-d-ambonnay.jpg',
                        'hsCode' => '2204.10.00',
                        'area' => 'Champagne',
                        'cuveeDomaine' => 'Clos d\'Abonnay',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 5
                    ],
                    
                ]
            ],
            [
                'name' => 'Vins Henri Ehrhart',
                'siret' => '312 856 982 00011',
                'vat' => 'FR 25 312856982',
                'picture' => 'https://alsace.nouvellesgastronomiques.com/photo/art/grande/22356466-25096492.jpg?v=1526829330',
                'validated' => 1,
                'presentation' => "C’est à Ammerschwihr, au cœur de la route des vins d’Alsace, que l’histoire du domaine familial prend sa source. Notre famille y travaille la vigne depuis huit générations.
                Ce village, ce terroir, ces cols, ces lacets qui serpentent de villages en villages, ce sont nos racines.
                C’est ici que notre père Henri Ehrhart, a appris le travail de la vigne auprès de notre grand-père, lequel tenait son métier de son père.
                Et c’est ici qu’Henri nous a transmis la passion de la vigne et du vin.",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Sophie',
                        'lastname' => 'EHRHART',
                        'email' => 'seller@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Sophie',
                        'lastname' => 'EHRHART',
                        'street' => 'Quartier des Fleurs',
                        'city' => 'Ammerschwihr',
                        'zipCode' => '68770',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '03 89 78 23 74'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Alsace Riesling',
                        'price' => 16,5,
                        'description' => "C'est tout d'abord un terroir exceptionnel. L'exposition, le sol, le climat, s'y unissent pour dessiner une aire de culture privilégiée de certains cépages. Cette primauté du terroir sur le cépage explique la tres grande typicité de ces vins : AOC Alsace Grand Cru.

                        Belle robe dorée, le nez s’ouvre sur des arômes de pêche blanche et d’aubépine. La bouche est tendue et racée sur des notes de citron confit, c’est un vin nerveux qui s’appréciera pour son caractère sec, typé du cépage. Ce Riesling de grande finesse accompagnera avec délicatesse les poissons grillé ou en sauce, les volailles et rôtis, les apéritifs dînatoire.",
                        'quantity' => 36000,
                        'vintage' => '2012',
                        'brand' => 'Henri Ehrhart',
                        'color' => 'Blanc',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'alcoholVolume' => 12,
                        'picture' => 'https://henri-ehrhart.com/images/vins/grand-cru-riesling.jpg',
                        'hsCode' => '2204.21.00',
                        'area' => 'Alsace',
                        'cuveeDomaine' => 'Grand Cru Kaefferkopf',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 5
                    ],
                    [
                        'appellation' => 'Crémant d\'Alsace',
                        'price' => 25,
                        'description' => "
                        La richesse d'un terroir, la passion d'une famille. Vieillie sur lattes pendant plus de 48 mois cette édition limitée se veut l'expression de la passion qui nous anime.
                        Le soin tout particulier apporté à la sélection des raisins se reflète dans sa robe dorée, son nez délicat, et sa finale tranchante.
                        D'une structure vineuse, d'une salinité et d'une complexité remarquables ce crémant de caractère est résolument un vin de gastronomie. Cépage : Pinot blanc, Chardonnay",
                        'quantity' => 4200,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Henri Ehrhart',
                        'color' => 'Blanc',
                        'type' => 'Effervescent',
                        'category' => 'AOP',
                        'alcoholVolume' => 12,
                        'picture' => 'https://henri-ehrhart.com/images/vins/passion-2014.jpg',
                        'hsCode' => '2204.10.00',
                        'area' => 'Alsace',
                        'cuveeDomaine' => 'Passion',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 5
                    ],
                    [
                        'appellation' => 'Alsace Pinot Gris',
                        'price' => 7,9,
                        'description' => "
                        Malgré la légende qui veut que le Seigneur Lazare de Schwendi, noble alsacien et mercenaire des empereurs d’Autriche, ait ramené ce cépage de Hongrie, le pinot gris est bourguignon, et l’on peut encore le trouver dans les vignobles de la Côte d’Or et de l’Yonne.
                        
                        Les vins de pinot gris présentent une robe jaune soutenue ; leurs arômes sont complexes : notes fumées de sous-bois mariées à de douces odeurs de fruits secs, d’abricot et de miel. En bouche ils se révèlent opulents et charpentés. Lorsqu’ils sont secs, ils ne craignent pas d’accompagner les mets réservés traditionnellement aux vins rouges, tels que viandes blanches ou petits gibiers. Plus doux, ils peuvent très bien se marier à la cuisine asiatique et forment un accord parfait avec le foie gras.
                        
                        Très adapté à l’élaboration de vendanges tardives et sélection de grains nobles, le pinot gris sait alors révéler d’enivrants caractères miellés.",
                        'quantity' => 24000,
                        'vintage' => '2014',
                        'brand' => 'Henri Ehrhart',
                        'color' => 'Blanc',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'alcoholVolume' => 12,
                        'picture' => 'https://henri-ehrhart.com/images/vins/classique-pinot-gris-2.jpg',
                        'hsCode' =>'2204.21.00',
                        'area' => 'Alsace',
                        'cuveeDomaine' => 'Réserve Particulière',
                        'capacity' => 750,
                        'status' => 0,
                        'rate' => 4
                    ],
                    [
                        'appellation' => 'Alsace Pinot Noir',
                        'price' => 7,9,
                        'description' => "
                        Bourguignon d’origine, il est apparu dès le Moyen-Âge en Alsace. Occupant une place très importante à cette époque, il a ensuite dû faire face à une longue période de déclin avant de connaître, depuis les années 50, un regain d’intérêt de la part des producteurs et des consommateurs.

                        Cépage noble par excellence, le pinot noir exige de la rigueur et une production maîtrisée. Il produit, sous le climat alsacien, un vin gouleyant et fruité (cassis, framboises, cerises), à la robe rubis étincelante, pour répondre à la demande d’un vin rouge souple aux tanins fondus et soyeux. Sur certains terroirs, les vins se font plus structurés et riches, leur robe plus sombre, et quelques années sont nécessaires à leur plein épanouissement.

                        Il accompagne toutes les volailles et les petits gibiers… Notre réserve particulière ne redoute pas les pièces de boeufs ou les plats en sauce, mais vous pouvez également servir nos vins avec un tajine d’agneau ou un couscous qu’ils sauront très bien mettre en valeur. Le temps et l’expérience nous ont permis de sélectionner des produits variés, afin de satisfaire toutes les exigences de notre clientèle.",
                        'quantity' => 18000,
                        'vintage' => '2014',
                        'brand' => 'Henri Ehrhart',
                        'color' => 'Rouge',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'alcoholVolume' => 12,
                        'picture' => 'https://henri-ehrhart.com/images/vins/classique-pinot-noir.jpg',
                        'hsCode' => '2204.21.00',
                        'area' => 'Alsace',
                        'cuveeDomaine' => 'Réserve Particulière',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 2
                    ],
                    
                ]
            ],
            [
                'name' => 'Cognac Tiffon',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://braastad.com/wp-content/uploads/2014/03/braastad_castle_02-FILEminimizer-480x300.jpg',
                'validated' => 1,
                'presentation' => "La maison TIFFON est riche d'une histoire franco-norvégienne om le passé et le présent se rejoignent.
                1875 : Médéric Tiffon fond la Maison Tiffon à Jarnac.
                1913 : Sverre Braastad épouse Edit Rousseau, la nièce du fondateur Médéric Tiffon.
                1919 : Sverre Braastad reprend l'entreprise familiale. Il développe la socété Cognac Tiffon SA, celle-ci étant l'une des plus grandes maisons toujours dirigée par une faimille dans l'aire du congaçais",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Edouard',
                        'lastname' => 'BRAASTAD',
                        'email' => 'seller4@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Edouard',
                        'lastname' => 'BRAASTAD',
                        'street' => '29 quai de l\'île Madame',
                        'city' => 'Jarnac',
                        'zipCode' => '16200',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Cognac',
                        'price' => 37,
                        'description' => "Le VSOP est un délicat assemblage de cognacs provenant principalement du cru des Fins Bois. Notes de dégustation : un nez élégant au caractère floral rond et doux. Le final a des poites d'épices et de vanille. Le VSOP Tiffon peut être dégusté sur glace ou en cocktail afin d'exalter son côté fruité",
                        'quantity' => 36000,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Tiffon',
                        'color' => 'Blanc',
                        'type' => 'Spiritueux',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://www.cognatheque.com/1264-large_default/cognac-tiffon-vsop.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Cognac',
                        'cuveeDomaine' => 'VSOP',
                        'capacity' => 700,
                        'status' => 1,
                        'rate' => 5
                    ],
                    [
                        'appellation' => 'Cognac',
                        'price' => 30,
                        'description' => "Le VS Tiffon est un assemblage de plusieurs cognacs spécialement sélectionnés pour leur fraîcheur/côté fruité des meilleurs crus de l'appelation Cognac.",
                        'quantity' => 36000,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Tiffon',
                        'color' => 'Blanc',
                        'type' => 'Spiritueux',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://www.cognatheque.com/1266-large_default/cognac-tiffon-vs.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Cognac',
                        'cuveeDomaine' => 'VS',
                        'capacity' => 700,
                        'status' => 1,
                        'rate' => 5
                    ],                   
                ]
            ],
            [
                'name' => 'Ca dépend & Co',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Place_Saint-%C3%89tienne_%28Toulouse%29.jpg/800px-Place_Saint-%C3%89tienne_%28Toulouse%29.jpg',
                'validated' => 1,
                'presentation' => "J'ai finalement pogné la twist pour faire la poutine. Je crisse mon camp d'icite anyway, je déguedine au plus sacrant, ça sent la cibole de marde. Osti qui fa frette. Ya 'ien qu'une affaire qui me démange, c'est de le pogner par les dessours de bras pis de le câlicer au travers du châssis. T'es de bonne heure sul piton toé à matin, quessé qui t'arrive ? T'es din patate mon gars, complètement dans le champ.",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Olivier',
                        'lastname' => 'BAROU',
                        'email' => 'seller5@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Olivier',
                        'lastname' => 'BAROU',
                        'street' => '2 Chemin de la Casquette',
                        'city' => 'Guéreins',
                        'zipCode' => '01090',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Saint-Pourçain',
                        'price' => 8,15,
                        'description' => "Robe jaune pâle et limpide à reflets verts. Le nez complexe exprime des fruits blancs (pêche, poire), d'agrumes et de fleurs blanches, ainsi qu’une touche miellée typique du Chardonnay majoritaire. La bouche développe une attaque ample et équilibrée, avec une belle longueur de fleurs et de fruits. ",
                        'quantity' => 36000,
                        'vintage' => '2017',
                        'brand' => 'Feun',
                        'color' => 'Blanc',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://default8988.blob.core.windows.net/cmsfiles/227/Product/1105/07ba996f-9301-46d5-b0ca-fca31e1ae2f3-zoom.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Auvergne',
                        'cuveeDomaine' => 'Nicole',
                        'capacity' => 700,
                        'status' => 1,
                        'rate' => 5
                    ],    
                ]
            ],
            [
                'name' => 'Vinaigrette SARL',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d4/Making_vinaigrette.jpg/800px-Making_vinaigrette.jpg',
                'validated' => 1,
                'presentation' => "Sa blonde m'en a sacré toute une au parcheesi, mais elle a été mardeuse. Mâ t'en faire moé des patentes de même, tu vas m'entendre baptinse. Calvenusse de tabarnouche de mausus de cârosse de patente à gosse. Mon char est resté pogné dans crisse de slotche toute la nuite. Il va manger un esti de char de marde tu vas vouère. T'es din patate mon gars, complètement dans le champ.",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Gaétan',
                        'lastname' => 'BENALOUL',
                        'email' => 'seller6@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Gaétan',
                        'lastname' => 'BENALOUL',
                        'street' => 'Faufichet',
                        'city' => 'Luceau',
                        'zipCode' => '72500',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Côtes de Provence',
                        'price' => 37,
                        'description' => "Marqué par la minéralité et la finesse d’expression. Volume en bouche, gras et rond. Dominante de fruits blancs, pêche de vigne et poire accompagnés de notes de fruits rouges. Une finale longue et fraîche. Galette de kasha au saumon fumé sauvage et caviar - Palette de porc au citron et courgettes à la niçoise -Ballotines de saumon au chou et au lard - Gambas flambées au whisky, potiron et crème de coco",
                        'quantity' => 36000,
                        'vintage' => '2019',
                        'brand' => 'La Brouette',
                        'color' => 'Rosé',
                        'type' => 'Tranquille',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://static.greenweez.com/images/products/112000/600/domaine-du-chardon-bleu-cuvee-ritournelle-bio.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Provence',
                        'cuveeDomaine' => 'AOP',
                        'capacity' => 700,
                        'status' => 1,
                        'rate' => 5
                    ],   
                ] 
            ],
            [
                'name' => 'Michu et fils',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Ancien_batiment_de_l%27abbaye_Notre-Dame_de_Bernay_DSC_0048.jpg/800px-Ancien_batiment_de_l%27abbaye_Notre-Dame_de_Bernay_DSC_0048.jpg',
                'validated' => 1,
                'presentation' => "Il va manger un esti de char de marde tu vas vouère. J'ai finalement pogné la twist pour faire la poutine. Mon char est resté pogné dans crisse de slotche toute la nuite. Je crisse mon camp d'icite anyway, je déguedine au plus sacrant, ça sent la cibole de marde. Heille les ti-culs, vous er'virez de bord drette là si vous pensez que vous vous écartez dans le bois talheure. Bon, câlisse, tu vas-tu me crisser patience ?",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Christophe',
                        'lastname' => 'DENEUVE',
                        'email' => 'seller7@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Christophe',
                        'lastname' => 'DENEUVE',
                        'street' => '4 Blvd de Rochechouart',
                        'city' => 'Paris',
                        'zipCode' => '75018',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '01 55 29 50 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Calvados',
                        'price' => 37,
                        'description' => "Le Calvados 12 ans a vieilli au minimum 12 ans en fûts de chêne avec 25% de barriques neuves. Les pommes sont mélangées, broyées et pressées. Le jus de pomme fermente complètement pour donner le cidre à distiller. La double distillation a lieu six mois après le processus de fermentation du cidre. La première distillation du cidre donne la petite eau à 30% vol. et c'est la seconde distillation, celle de la petite eau, qui donne le Calvados. Elevage : Douze ans minimum. En barriques de chêne toasté de 400 litres dont 25% de barriques neuves. Mise en bouteille à la commande.",
                        'quantity' => 36000,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Tati',
                        'color' => 'Blanc',
                        'type' => 'Spiritueux',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://www.lagrandeepicerie.com/on/demandware.static/-/Sites-lge-master-catalog/default/dw595ef517/images/DIS/3297360010269_1.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Normandie',
                        'cuveeDomaine' => '12 ans',
                        'capacity' => 700,
                        'status' => 1,
                        'rate' => 5
                    ],    
                ]
            ],
            [
                'name' => 'SCEA Inepoute',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/Eglise_Saint-Etienne_de_Saleilles.jpg/1600px-Eglise_Saint-Etienne_de_Saleilles.jpg',
                'validated' => 1,
                'presentation' => "Yé un peu niaiseux le niochon de voisin, il crisse eu'rien avec sa vie. Ben coudonc, t'es encore là toé ? Des patates pilées, du steak haché, du maïs en crème, pis kin toé, du pâté chinois. Je crisse mon camp d'icite anyway, je déguedine au plus sacrant, ça sent la cibole de marde. Baptême de crisse de cibole de viande à chien, j'en ai plein mon casse d'être toute décalissé de la vie, avec le windshier de mon char toute déviargé par l'autre esti de cave. Toryeu que c'est cheap cette esti de cochonnerie-là.",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Sébastien',
                        'lastname' => 'LAMPAZONA',
                        'email' => 'seller8@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Sébastien',
                        'lastname' => 'LAMPAZONA',
                        'street' => '36 Allée des Sapins',
                        'city' => 'Bourg-lès-Valence',
                        'zipCode' => '26500',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Muscat de Rivesaltes',
                        'price' => 12,5,
                        'description' => "Un premier nez floral évolue vers les agrumes mûrs et les fruits exotiques. En bouche, cette complexité aromatique évolue vers une finale fraîche mentholée, et légèrement épicée.
                        Servir à 8°C. Apéritif, Roquefort, desserts aux fruits blancs et à la vanille.",
                        'quantity' => 1800,
                        'vintage' => '2018',
                        'brand' => 'Epic fail',
                        'color' => 'Blanc',
                        'type' => 'Liqueur',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://www.cazes-rivesaltes.com/wp-content/uploads/2017/04/MUSCAT-DE-RIVESALTES-NM.png',
                        'hsCode' => '2204.21.00',
                        'area' => 'Languedoc',
                        'cuveeDomaine' => 'Adopte un dev',
                        'capacity' => 750,
                        'status' => 1,
                        'rate' => 5
                    ],    
                ]
            ],
            [
                'name' => 'Milo le Chat',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://live.staticflickr.com/7133/7717473276_a1d4c92c13_b.jpg',
                'validated' => 1,
                'presentation' => "T'es din patate mon gars, complètement dans le champ. Baptême de crisse de cibole de viande à chien, j'en ai plein mon casse d'être toute décalissé de la vie, avec le windshier de mon char toute déviargé par l'autre esti de cave. Ferme-toé un peu le mâche-patate là, va prendre une marche ou quelque chose. Quessé tu veux j'te dise sacrament, fouille-moé bout d'viarge, je le sais-tu moé. Ben coudonc, t'es encore là toé ? Ya 'ien qu'une affaire qui me démange, c'est de le pogner par les dessours de bras pis de le câlicer au travers du châssis.",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Djyp',
                        'lastname' => 'FOREST FORTIN',
                        'email' => 'seller9@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Djyp',
                        'lastname' => 'FOREST FORTIN',
                        'street' => '78 Avenue du Québec',
                        'city' => 'Villebon-sur-Yvette',
                        'zipCode' => '91140',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Vin de glace',
                        'price' => 29,90,
                        'description' => "Pour produire le vin de glace, on attend que la température descende en dessous de -8°C. En effet, le raisin doit être récolté gelé puis immédiatement pressé avant d’être mis en fermentation. S’en suit une lente période de maturation qui donnera ce nectar sucré aux arômes riches. Les grandes difficultés d’élaboration du vin de glace, et le faible rendement des parcelles destinées à le produire, en font un produit très rare et assez dispendieux !  Le vin de glace du Cep d’Argent présente une bouche gourmande toute en rondeur avec une belle persistance. Des touches de fruits confits, de miel, de pomme au four, et de chicouté (ronce petit-mûrier). Magnifique sur un foie gras, un fromage bleu, en apéritif ou en vin de dessert…",
                        'quantity' => 36000,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Le Cep d’Argent',
                        'color' => 'Blanc',
                        'type' => 'Liqueur',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://epicerie-quebecoise.com/361-product_page/vin-de-glace.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Canada',
                        'cuveeDomaine' => 'Milo',
                        'capacity' => 200,
                        'status' => 1,
                        'rate' => 5
                    ],    
                ]   
            ],
            [
                'name' => 'La compagnie créole',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://live.staticflickr.com/5626/22601432952_e9f9ebea6e_b.jpg',
                'validated' => 1,
                'presentation' => "J'ai ben d'la misère avec les colons en bedaine. Je lui ai garôché une estie de garnotte en plein dans sa crisse de face de crosseur, il en menait pas large je te jure. Ben coudonc, t'es encore là toé ? Ça a fessé dans le dash en esti hier, j'étais paqueté en tabarnak, je suis crissement lendemain de veille. T'es din patate mon gars, complètement dans le champ. Mâ t'en faire moé des patentes de même, tu vas m'entendre baptinse.",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Luc',
                        'lastname' => 'HIDALGO',
                        'email' => 'seller10@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Luc',
                        'lastname' => 'HIDALGO',
                        'street' => '5 rue de Lobau',
                        'city' => 'Paris',
                        'zipCode' => '75004',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Rhum',
                        'price' => 37,
                        'description' => "le rhum blanc agricole Damoiseau se distingue par sa richesse aromatique marquée par de délicates notes sucrées, florales et épicées.",
                        'quantity' => 36000,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Damoiseau',
                        'color' => 'Blanc',
                        'type' => 'Spiritueux',
                        'category' => 'AOP',
                        'alcoholVolume' => 40,
                        'picture' => 'https://farm5.staticflickr.com/4118/4862732568_4ca5699ec5_b.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Guadeloupe',
                        'cuveeDomaine' => 'Yoda',
                        'capacity' => 700,
                        'status' => 1,
                        'rate' => 5
                    ],    
                ]
            ],
            [
                'name' => 'Québec Ipsum Corporation Inc',
                'siret' => '905 720 041 00052',
                'vat' => 'FR 15 905720041',
                'picture' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Quebec_City.jpg/800px-Quebec_City.jpg',
                'validated' => 1,
                'presentation' => "Ben coudonc, t'es encore là toé ? Lâche pas la patate, enwoye, tu rentres la gogosse dans la slot pis ça va le faire. Je m'en crisse, mais câlicement. Arrête de faire la baboune tabaslack, a va fondre la slutch. Mâ t'en faire moé des patentes de même, tu vas m'entendre baptinse. Il m'a même pas redonné mon ptit change, ya essayé de me crosser le câlice. T'es de bonne heure sul piton toé à matin, quessé qui t'arrive ? Ben coudonc, t'es encore là toé ? Les crottes de fromage, bien sqouick sqouick dans yeule, c'est ça le bonheur. Yé un peu niaiseux le niochon de voisin, il crisse eu'rien avec sa vie. Quessé tu veux j'te dise sacrament, fouille-moé bout d'viarge, je le sais-tu moé. Bon, câlisse, tu vas-tu me crisser patience ?",
                'rate' => 5,
                'seller' => [
                    [
                        'firstname' => 'Guillaume',
                        'lastname' => 'SYLVESTRE',
                        'email' => 'seller11@mail.fr',
                        'password' => password_hash("banane", PASSWORD_DEFAULT),
                        'roles' => ['ROLE_SELLER']
                    ]
                ],
                'address' => [
                    [
                        'firstname' => 'Guillaume',
                        'lastname' => 'SYLVESTRE',
                        'street' => '18 Avenue du Canada',
                        'city' => 'Rennes',
                        'zipCode' => '35200',
                        'country' => 'France',
                        'iso' => 'FR',
                        'phoneNumber' => '05 45 36 87 00'
                    ]
                ],
                'packages' => [

                ],
                'destinations' => [

                ],
                'products' => [
                    [
                        'appellation' => 'Crème d\'érable',
                        'price' => 24,90,
                        'description' => "Cette crème d'érable légèrement alcoolisée est un délice ! Ce produit est élaborée avec un sirop d'érable du Québec 100% pur de première qualité, de la crème fraîche, de l'alcool de grains et un soupçon de rhum. A servir sur glace, comme un Bailey's, ou bien à verser dans un café, un chocolat ou à utiliser en cocktail. La crème Coureur des Bois ravira les amateurs de Bailey's en apportant la saveur de l'érable en plus. Une pure gourmandise à consommer avec modération...",
                        'quantity' => 18000,
                        'vintage' => 'Non millésimé',
                        'brand' => 'Coureur des Bois',
                        'color' => 'Blanc',
                        'type' => 'Liqueur',
                        'category' => 'AOP',
                        'alcoholVolume' => 15,
                        'picture' => 'https://epicerie-quebecoise.com/353-product_page/creme-d-erable-coureur-des-bois.jpg',
                        'hsCode' => '2208.21',
                        'area' => 'Canada',
                        'cuveeDomaine' => 'Coureur des Bois',
                        'capacity' => 700,
                        'status' => 1,
                        'rate' => 5
                    ],    
                ]
            ]
        ];
        
        
        foreach($companyList as $currentCompany){
            $company = new Company();
            $company->setName($currentCompany['name']);
            $company->setSiret($currentCompany['siret']);
            $company->setVat($currentCompany['vat']);
            $company->setPicture($currentCompany['picture']);
            $company->setPresentation($currentCompany['presentation']);
            $company->setRate($currentCompany['rate']);
            $company->setValidated($currentCompany['validated']);
            foreach($currentCompany['seller'] as $companySeller){
                $seller = new User();
                $seller->setFirstname($companySeller['firstname']);
                $seller->setLastname($companySeller['lastname']);
                $seller->setEmail($companySeller['email']);
                $seller->setPassword($companySeller['password']);
                $seller->setRoles($companySeller['roles']);
                $company->addSeller($seller);
                foreach($currentCompany['address'] as $companyAddress){
                    $address = new Address();
                    $address->setFirstname($currentCompany['seller'][0]['firstname']);
                    $address->setLastname($currentCompany['seller'][0]['lastname']);
                    $address->setStreet($companyAddress['street']);
                    $address->setCity($companyAddress['city']);
                    $address->setZipCode($companyAddress['zipCode']);
                    $address->setCountry($companyAddress['country']);
                    $address->setIso($companyAddress['iso']);
                    $address->setPhoneNumber($companyAddress['phoneNumber']);
                    $seller->addAddress($address);
                    $manager->persist($address);
                }
                $manager->persist($seller);
            }
            foreach($currentCompany['products'] as $currentProduct){
                $product = new Product();
                $product->setAppellation($appellationList[$currentProduct['appellation']]);
                $product->setPrice($currentProduct['price']);
                $product->setDescription($currentProduct['description']);
                $product->setStockQuantity($currentProduct['quantity']);
                $product->setVintage($currentProduct['vintage']);
                $product->setBrand($brandList[$currentProduct['brand']]);
                $product->setColor($colorList[$currentProduct['color']]);
                $product->setType($typeList[$currentProduct['type']]);
                $product->addCategory($categoryList[$currentProduct['category']]);
                $product->setAlcoholVolume($currentProduct['alcoholVolume']);
                $product->setPicture($currentProduct['picture']);
                $product->setHsCode($currentProduct['hsCode']);
                $product->setArea($currentProduct['area']);
                $product->setRate($currentProduct['rate']);
                $product->setCuveeDomaine($currentProduct['cuveeDomaine']);
                $product->setCapacity($currentProduct['capacity']);
                $product->setStatus($currentProduct['status']);
                $company->addProduct($product);
                $manager->persist($product);
            }
            $manager->persist($company);
        }

        // --------------------------------------------------------- Buyer/Admin de test --------------------------------------------
        // On crée un user de chaque role 
        $buyer = new User();
        $admin = new User();
        $buyerAddress = new Address();
        $adminAddress = new Address();
        
        $buyer->setRoles(['ROLE_USER', 'ROLE_BUYER']);
        $admin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $buyer->setEmail('buyer@mail.fr');
        $admin->setEmail('admin@mail.fr');

        $buyer->setPassword(password_hash("banane", PASSWORD_DEFAULT));
        $admin->setPassword(password_hash("banane", PASSWORD_DEFAULT));

        $buyer->setFirstname($faker->firstName);
        $buyer->setLastname($faker->lastName);

        $admin->setFirstname($faker->firstName);
        $admin->setLastname($faker->lastName);

        $buyerAddress->setFirstname($buyer->getFirstname());
        $buyerAddress->setLastname($buyer->getLastname());
        $buyerAddress->setZipCode('76000');
        $buyerAddress->setCity('Rouen');
        $buyerAddress->setCountry('France');
        $buyerAddress->setIso('FR');
        $buyerAddress->setPhoneNumber('0102030405');
        $buyerAddress->setStreet('40 Rue Molière');
        $buyerAddress->setType(['DELIVERY_ADDRESS', 'BILLING_ADDRESS']);
        $buyer->addAddress($buyerAddress);

        $adminAddress->setFirstname($admin->getFirstname());
        $adminAddress->setLastname($admin->getLastname());
        $adminAddress->setZipCode($faker->postcode);
        $adminAddress->setCity($faker->city);
        $adminAddress->setCountry($faker->country);
        $adminAddress->setIso($faker->countryCode);
        $adminAddress->setPhoneNumber($faker->phoneNumber);
        $adminAddress->setStreet($faker->streetAddress);
        $admin->addAddress($adminAddress);

        $buyer->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
        $admin->setCreatedAt($faker->unique()->dateTime($max = 'now', $timezone = null));
        $userBuyer[] = $buyer;

        $manager->persist($buyer);
        $manager->persist($admin);
        $manager->persist($buyerAddress);
        $manager->persist($adminAddress);
        
        $manager->flush();
    }
}