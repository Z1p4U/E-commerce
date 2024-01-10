<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                "name" => "After Shave",
                "description" => ""
            ],
            [
                "name" => "Air Fresher",
                "description" => ""
            ],
            [
                "name" => "Aldehydic",
                "description" => "An abstract soapy, fatty, fresh smell, reminiscent of fresh laundry and frost."
            ],
            [
                "name" => "Almond",
                "description" => "It is gourmand bitter-sweet note, soft and nutty. Bitter almond oil is produced not only from almonds, but cherries, apricots, peaches, and prunes."
            ],
            [
                "name" => "Amber",
                "description" => "A sweet, resinous, cozy and warm, often rather powdery note recreated from a mix of balsams, usually labdanum, benzoin, vanilla, styrax and fir or a combination of some of these. A default oriental note."
            ],
            [
                "name" => "Animalic",
                "description" => "Different ingredients, synthetic and natural, can produce an animalic dirty and deep sensual effect."
            ],
            [
                "name" => "Anis",
                "description" => "The scent of aniseed, rich in anethol, reminiscent of licorice. Belongs in the same family of scents as tarragon and fennel (also rich in anethol). Very popular in fragrances, notably L’Heure Bleu."
            ],
            [
                "name" => "Aquatic",
                "description" => "Aquatic scents will often use ‘saltier’ ingredients such as seawood, oakmoss or cedarwood to achieve a marine freshness. For example, the base notes in Sel Marin by Heeley, an unsurpassed aquatic, evoke thoughts of vetiver, cedarwood and birch drying in the warm Mediterranean sun."
            ],
            [
                "name" => "Aromatic",
                "description" => "Aromatic notes are usually combined of sage, rosemary, cumin, lavender and other plants which possess a very intensive grass-spicy scent. They are often combined with citrusy and spicy notes. Aromatic compositions are typical of fragrances for men."
            ],
            [
                "name" => "Award Winner",
                "description" => ""
            ],
            [
                "name" => "Balsamic",
                "description" => "Overall, balsamic notes have a soothing, balmy, warm, even animalic or slightly medicinal scent. They are strong and persistent notes that envelop a fragrance. They often support and complement the vanilla in a fragrance."
            ],
            [
                "name" => "Beeswax",
                "description" => "Beeswax ပျားဖယောင်း
                A deep aromatic amber fragrance with an intense honey nuance."
            ],
            [
                "name" => "Beverages",
                "description" => ""
            ],
            [
                "name" => "Body Cream",
                "description" => ""
            ],
            [
                "name" => "Body lotion",
                "description" => ""
            ],
            [
                "name" => "Body Mist",
                "description" => ""
            ],
            [
                "name" => "Brand Category",
                "description" => ""
            ],
            [
                "name" => "Cacao",
                "description" => ""
            ],
            [
                "name" => "Cannabis",
                "description" => "An aromatic smoky note with a dirty sour nuance."
            ],
            [
                "name" => "Caramel",
                "description" => "A candy-deep, sensual and rich, creamy buttery lactonic note that enriches gourmand perfumes and adds sweetness to floral compositions."
            ],
            [
                "name" => "Celebrity",
                "description" => ""
            ],
            [
                "name" => "Champagne",
                "description" => ""
            ],
            [
                "name" => "Cherry",
                "description" => "A popular fruity note, sweet and tart at the same time, with a characteristic bitter almond nuance."
            ],
            [
                "name" => "Chocolate",
                "description" => ""
            ],
            [
                "name" => "Cinnamon",
                "description" => "A sweet and warm, powdery tenacious spicy note."
            ],
            [
                "name" => "Citrus",
                "description" => "A category of hesperidic fruits of different varieties."
            ],
            [
                "name" => "Coconut",
                "description" => "A tropical fruity nutty sweet note with vanilla, milky nuances."
            ],
            [
                "name" => "Coffee",
                "description" => "Coffee berries are produced by the evergreen bush of the genus Coffea. In perfumes the coffee note is an intense, dark roast facet that is linked to the cocoa facet of patchouli in Borneo 1834 (Lutens). Famously put in good use in A*men by Mugler, L’Or de Torrente"
            ],
            [
                "name" => "Decant",
                "description" => ""
            ],
            [
                "name" => "Deo Roll On",
                "description" => ""
            ],
            [
                "name" => "Deo Stick",
                "description" => ""
            ],
            [
                "name" => "Deodorant",
                "description" => ""
            ],
            [
                "name" => "Designer",
                "description" => ""
            ],
            [
                "name" => "Dupe",
                "description" => ""
            ],
            [
                "name" => "Earthy",
                "description" => "Earthy notes are sourced from different ingredients: moss, orris root, vetiver, etc."
            ],
            [
                "name" => "Eau De Cologne",
                "description" => ""
            ],
            [
                "name" => "Eau De Parfum",
                "description" => ""
            ],
            [
                "name" => "Eau De Toilette",
                "description" => ""
            ],
            [
                "name" => "Essence De Parfum",
                "description" => ""
            ],
            [
                "name" => "Extrait De Parfum",
                "description" => ""
            ],
            [
                "name" => "Floral",
                "description" => "Floral notes are an essential part of almost every perfume. They can be natural or synthetic."
            ],
            [
                "name" => "Flowers",
                "description" => ""
            ],
            [
                "name" => "Fresh",
                "description" => ""
            ],
            [
                "name" => "Fresh Spicy",
                "description" => ""
            ],
            [
                "name" => "Fruits",
                "description" => ""
            ],
            [
                "name" => "Fruity",
                "description" => "Fresh and sweet fruity notes enhance the beauty and naturalness of floral notes."
            ],
            [
                "name" => "Full Size",
                "description" => ""
            ],
            [
                "name" => "Gender",
                "description" => ""
            ],
            [
                "name" => "Gift Set",
                "description" => ""
            ],
            [
                "name" => "Green",
                "description" => "A generic term for notes that evoke snapped leaves, foliage, green vegetal scents."
            ],
            [
                "name" => "Hair Mist",
                "description" => ""
            ],
            [
                "name" => "Herbal",
                "description" => "The herbal fragrances are made using herbal fragrance ingredients, which has all natural and herbal ingredients in it. The chemical and synthetic fragrances have a toxic effect on the human skin if exposed to it on prolonged period of time."
            ],
            [
                "name" => "Herbs & Fougeres",
                "description" => ""
            ],
            [
                "name" => "Honey",
                "description" => "A sweet, gourmand scent with animalic and powdery floral nuances."
            ],
            [
                "name" => "Iris",
                "description" => "A natural iris (iris root) note is earthy, woody, powdery, reminiscent of boiled carrot. A fantasy iris note is a powdery floral, reminiscent of the violet flower."
            ],
            [
                "name" => "Kid",
                "description" => ""
            ],
            [
                "name" => "Lactonic",
                "description" => "Sweet, coconut creamy, milky with a phthalate celery like note and a fatty melted butter and dry lactonic cheese like nuance. flavor: Waxy, sweetened coconut, dairy creamy with a melted butter, slightly brown butter and toffee like nuance."
            ],
            [
                "name" => "Lavender",
                "description" => "An aromatic floral clean note, with green, fresh spicy, licorice facets."
            ],
            [
                "name" => "Leather",
                "description" => "Synthetic or naturally derived note of pungent characteristics, reminiscent of cured hides and leather goods. Usually rendered by birch tar or by synth isoquinolines."
            ],
            [
                "name" => "Limited Editon",
                "description" => ""
            ],
            [
                "name" => "Marine",
                "description" => ""
            ],
            [
                "name" => "Mass",
                "description" => ""
            ],
            [
                "name" => "Men",
                "description" => ""
            ],
            [
                "name" => "Milky",
                "description" => "A warm, comfortable gourmand, but not too sweet note."
            ],
            [
                "name" => "Mineral",
                "description" => ""
            ],
            [
                "name" => "Mini",
                "description" => ""
            ],
            [
                "name" => "Mini Gift Set",
                "description" => ""
            ],
            [
                "name" => "Mossy",
                "description" => ""
            ],
            [
                "name" => "Musk",
                "description" => "There is a wide variety of sources for musk smelling materials, including synthetic musks and natural ones, mainly obtained from plants, since deer musk is forbidden to obtain and sell. The musk is a secretion inside an internal pouch on the abdomen of the male deer. In order to get it, you have to kill the deer."
            ],
            [
                "name" => "Musky",
                "description" => ""
            ],
            [
                "name" => "Natural & Synthetic",
                "description" => ""
            ],
            [
                "name" => "Niche",
                "description" => ""
            ],
            [
                "name" => "Nutty",
                "description" => ""
            ],
            [
                "name" => "Oriental",
                "description" => "The term ‘Oriental’ in the perfume world refers to an historic fragrance family classification that encompassed notes like amber, sandalwood, coumarin, orris, vanilla and gum resins. The majority of major fragrance houses still use the term to classify scents with these ingredients."
            ],
            [
                "name" => "Oud",
                "description" => "A pathological secretion of the aquillaria tree, a rich, musty woody-nutty scent that is highly prized in the Middle East. In commercial perfumery, it’s safe to say all “oud” is a recreated synthetic note."
            ],
            [
                "name" => "Ozonic",
                "description" => "A fresh fantasy accord."
            ],
            [
                "name" => "Parfum",
                "description" => ""
            ],
            [
                "name" => "Patchouli",
                "description" => "An exotic bush that grows mainly in India, the leaves of which produce the essential oil of patchouli. Sweet, dark, with an earthy, woody edge, it is very popular in many blends, especially the contemporary woody floral musks. There are also synthetics and fractal extractions."
            ],
            [
                "name" => "Perfume Oil",
                "description" => ""
            ],
            [
                "name" => "Perfumer",
                "description" => ""
            ],
            [
                "name" => "Popular & Weird",
                "description" => ""
            ],
            [
                "name" => "Powdery",
                "description" => "A vast variety of natural and synthetic notes give a powdery effect to perfume composition. Most usual powder notes are iris/orris, violet, vanilla, rose, musks, heliotrope, opoponax resin, and some amber materials."
            ],
            [
                "name" => "Product Type",
                "description" => ""
            ],
            [
                "name" => "Resins & Balsams",
                "description" => ""
            ],
            [
                "name" => "Rose",
                "description" => "The king of flowers, lemony fresh with various nuances of powder, wood notes or fruit, feminine, clean, intensely romantic"
            ],
            [
                "name" => "Rum",
                "description" => "A complex, sweet and aromatic chord that brings on succulence and molasses-tinged nuances to gourmands and woody fragrances."
            ],
            [
                "name" => "Salty",
                "description" => "A savory note that can render interesting a marine, woody or -more intriguingly- a gourmand composition."
            ],
            [
                "name" => "Scent Compound (Top-Middle-Base)",
                "description" => "Scent Profile"
            ],
            [
                "name" => "Scent Profile (Accord)",
                "description" => ""
            ],
            [
                "name" => "Set",
                "description" => ""
            ],
            [
                "name" => "Shower Gel",
                "description" => ""
            ],
            [
                "name" => "Size",
                "description" => ""
            ],
            [
                "name" => "Smoky",
                "description" => "Different ingredients can produce a smoky effect (birch tar, different incenses)."
            ],
            [
                "name" => "Soft Spicy",
                "description" => ""
            ],
            [
                "name" => "Spices",
                "description" => "There are different spices obtained from different sources: seeds, fruits, barks, roots, leaves, and flowers. They can be fresh or warm, sour or sweet."
            ],
            [
                "name" => "Spicy",
                "description" => ""
            ],
            [
                "name" => "Sponsor (Car)",
                "description" => ""
            ],
            [
                "name" => "Sweet",
                "description" => ""
            ],
            [
                "name" => "Sweets & Gourmand",
                "description" => ""
            ],
            [
                "name" => "Tester Pack",
                "description" => ""
            ],
            [
                "name" => "Tobacco",
                "description" => "A rich, nuanced, warm and sweet herbaceous scent, with a note of whiskey, caramel, and hay."
            ],
            [
                "name" => "Travel Set",
                "description" => ""
            ],
            [
                "name" => "Travel Size",
                "description" => ""
            ],
            [
                "name" => "Tropical",
                "description" => "A general scent of sweet, lush, mouthwatering tropical fruits: coconut, pineapple, guava, etc."
            ],
            [
                "name" => "Tube (Sample)",
                "description" => ""
            ],
            [
                "name" => "Tube Set",
                "description" => ""
            ],
            [
                "name" => "Tuberose",
                "description" => "An intense white floral, carnal, sweet and indolic fragrance note, with green nuances."
            ],
            [
                "name" => "Unisex",
                "description" => ""
            ],
            [
                "name" => "Vanilla",
                "description" => "An ever popular fragrance note, known mostly through its synthetic variant vanillin, which is sweet, cozy, comforting, with a pleasing cookie-baking feeling to it. Alongside amber, the reference note for the Oriental family of scents (The most famous classic being Shalimar). The real vanilla pod has darker facets that recall treacle and booze with off notes. Simple vanillas (Victoria’s Secret Love to Dream, Charlie Touch, TBS Vanilla, Coty Vanilla Musk) have become increasingly popular with the adolescent market, giving rise to the umbiquity of the gourmand category of scents, while complex, earthier vanillas are appearing steadily in the niche sector (Spirituese Double Vanille by Guerlain, Tihota Indult, Montale Vanille Absolue)."
            ],
            [
                "name" => "Vegetables & Nuts",
                "description" => ""
            ],
            [
                "name" => "Violet",
                "description" => "A sweet and powdery, airy and dewy floral note."
            ],
            [
                "name" => "Vodka",
                "description" => "A mild alcoholic note of slight aromatic piquancy."
            ],
            [
                "name" => "Warm Spicy",
                "description" => "Warm spicy fragrances are, frankly, sultry. Warm, sensual notes of cardamom, incense, and pepper are common. Basically, this is the perfume one would wear if they wanted to feel mysterious."
            ],
            [
                "name" => "White Floral",
                "description" => "A white floral heady fragrance reminiscent of jasmine, gardenia, and tuberose."
            ],
            [
                "name" => "Women",
                "description" => ""
            ],
            [
                "name" => "Woods & Mosses",
                "description" => ""
            ],
            [
                "name" => "Woody",
                "description" => "Umbrella term used to refer to fragrance notes coming from woody materials (trees mostly, as well as some bushes -such as patchouli- or a few grasses -such as vetiver)."
            ],
            [
                "name" => "Yellow Floral",
                "description" => ""
            ],
        ];

        Category::insert($categories);
    }
}
