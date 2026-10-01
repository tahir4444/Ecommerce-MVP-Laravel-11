<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        $products = [
            [
                'category_slug' => 'outerwear',
                'name' => 'L\'Hiver Double-Breasted Wool Overcoat',
                'slug' => 'l-hiver-double-breasted-wool-overcoat',
                'short_description' => 'Heavyweight 100% virgin Italian melton wool with horn buttons.',
                'description' => 'Masterfully tailored in Tuscany from unbrushed virgin melton wool. Features wide peaked lapels, genuine buffalo horn buttons, dual jet pockets, and cupro satin lining for effortless drape over tailored suits or cashmere knitwear.',
                'price' => 580.00,
                'original_price' => 690.00,
                'sku' => 'OVR-LHV-01',
                'stock' => 18,
                'rating' => 4.9,
                'reviews_count' => 86,
                'badge' => 'SIGNATURE',
                'featured_image' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Material' => '100% Virgin Italian Melton Wool (720 GSM)',
                    'Lining' => '100% Bemberg Cupro Satin',
                    'Origin' => 'Handcrafted in Florence, Italy',
                    'Fit' => 'Structured Relaxed Silhouette',
                    'Care' => 'Specialist Dry Clean Only',
                ],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_slug' => 'outerwear',
                'name' => 'Atelier Weatherproof Gabardine Trench',
                'slug' => 'atelier-weatherproof-gabardine-trench',
                'short_description' => 'Water-repellent compact cotton gabardine with removable belt.',
                'description' => 'An archival trench coat silhouette re-engineered with tightly woven stormproof cotton gabardine. Detailed with epaulettes, a storm shield back flap, gun flap, and horn buckle adjustments.',
                'price' => 460.00,
                'original_price' => null,
                'sku' => 'OVR-TRN-02',
                'stock' => 14,
                'rating' => 4.8,
                'reviews_count' => 44,
                'badge' => 'NEW RELEASE',
                'featured_image' => 'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Material' => '100% Compact Egyptian Cotton Gabardine',
                    'Finish' => 'PFC-Free Hydrophobic Stormproof Treatment',
                    'Hardware' => 'Engraved Solid Brass Buckles',
                    'Fit' => 'Regular Heritage Fit',
                    'Care' => 'Dry Clean',
                ],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_slug' => 'knitwear',
                'name' => 'Mongolian Cashmere Turtleneck Sweater',
                'slug' => 'mongolian-cashmere-turtleneck-sweater',
                'short_description' => '2-ply 100% pure Grade-A Mongolian cashmere with ribbed cuffs.',
                'description' => 'Incomparable softness and cloud-like warmth. Spun from sustainably combed underfleece with long staple fibers to resist pilling. Finished with tubular ribbed cuffs, collar, and hem.',
                'price' => 320.00,
                'original_price' => 380.00,
                'sku' => 'KNT-CSH-03',
                'stock' => 25,
                'rating' => 5.0,
                'reviews_count' => 112,
                'badge' => 'BESTSELLER',
                'featured_image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Yarn' => '100% Grade-A Mongolian Cashmere (15.5 Micron)',
                    'Gauge' => '12GG 2-Ply Fine Knit',
                    'Weight' => '310 grams',
                    'Fit' => 'Classic Tailored Fit',
                    'Care' => 'Hand Wash Cold or Delicate Dry Clean',
                ],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_slug' => 'knitwear',
                'name' => 'Heavy Rib Fisherman Cardigan',
                'slug' => 'heavy-rib-fisherman-cardigan',
                'short_description' => 'Unbleached British wool with natural genuine corozo nut buttons.',
                'description' => 'Traditional 5-gauge chunky cardigan knit from hearty British fleece. Features a fold-over shawl collar, raglan sleeves for ease of movement, and deep patch pockets.',
                'price' => 280.00,
                'original_price' => 320.00,
                'sku' => 'KNT-FSH-04',
                'stock' => 20,
                'rating' => 4.7,
                'reviews_count' => 39,
                'badge' => 'AUTUMN ESSENTIAL',
                'featured_image' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Material' => '100% Pure British Lambswool',
                    'Buttons' => 'Natural Ecuadorian Corozo Nut',
                    'Fit' => 'Slightly Boxy Relaxed Fit',
                    'Weight' => '780 grams',
                ],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_slug' => 'tailored-essentials',
                'name' => 'Riviera Structured Linen Overshirt',
                'slug' => 'riviera-structured-linen-overshirt',
                'short_description' => 'Washed Normandy flax linen with dual flap chest pockets.',
                'description' => 'An effortless layering piece designed for temperate climates and breezy evenings. Pre-washed for a supple drape and tactile texture that grows softer with every wear.',
                'price' => 195.00,
                'original_price' => 230.00,
                'sku' => 'TLR-LNN-05',
                'stock' => 32,
                'rating' => 4.8,
                'reviews_count' => 63,
                'badge' => 'POPULAR',
                'featured_image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Material' => '100% French Normandy Flax Linen',
                    'Weight' => '240 GSM Pre-softened',
                    'Buttons' => 'Mother of Pearl Trocas Buttons',
                    'Fit' => 'Relaxed Overshirt Fit',
                ],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_slug' => 'tailored-essentials',
                'name' => 'Milano Double-Pleat Wide Wool Trousers',
                'slug' => 'milano-double-pleat-wide-wool-trousers',
                'short_description' => 'High-rise drape trousers with side adjusters and gentle taper.',
                'description' => 'Cut with a generous high rise and deep double forward pleats that flow into a gentle taper. Equipped with brass side adjusters, a split waistband curtain, and unfinished hems for tailored personalization.',
                'price' => 240.00,
                'original_price' => 290.00,
                'sku' => 'TLR-TRS-06',
                'stock' => 19,
                'rating' => 4.9,
                'reviews_count' => 51,
                'badge' => 'BESTSELLER',
                'featured_image' => 'https://images.unsplash.com/photo-1506630448388-4e683c67ddb0?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Material' => '100% Super 120s High-Twist Wool Flannel',
                    'Rise' => 'High Rise (12.5" on size 32)',
                    'Closure' => 'Extended Tab with Concealed Hook & Zip Fly',
                    'Adjusters' => 'Dual Brass Side Buckles',
                ],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_slug' => 'footwear',
                'name' => 'The Chelsea Leather Boot in Espresso',
                'slug' => 'chelsea-leather-boot-espresso',
                'short_description' => 'Goodyear welted box calfskin with Vibram studded rubber sole.',
                'description' => 'Constructed on our sleek almond last using full-grain French calfskin with deep vegetable-aniline dye. Goodyear welted to allow infinite re-soling, anchored by durable all-weather Vibram rubber outsoles.',
                'price' => 395.00,
                'original_price' => 450.00,
                'sku' => 'FTW-CHL-07',
                'stock' => 16,
                'rating' => 4.9,
                'reviews_count' => 134,
                'badge' => 'STAFF PICK',
                'featured_image' => 'https://images.unsplash.com/photo-1638247025967-b4e38f787b76?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Upper' => 'Full-Grain French Box Calfskin',
                    'Construction' => '360° Goodyear Welted',
                    'Outsole' => 'Custom Studded Vibram Rubber',
                    'Insole' => 'Full Leather Cork-Bed Insole',
                    'Origin' => 'Artisanal Workshop in Almansa, Spain',
                ],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_slug' => 'leather-goods',
                'name' => 'Verona Vegetable-Tanned Weekender Duffle',
                'slug' => 'verona-vegetable-tanned-weekender-duffle',
                'short_description' => 'Full-grain Tuscan vachetta leather with solid brass hardware.',
                'description' => 'The quintessential travel duffle, sized to fit international carry-on requirements. Crafted with thick full-grain vachetta leather that patinas richly over years of journeys. Features padded shoulder straps and waterproof twill lining.',
                'price' => 520.00,
                'original_price' => 610.00,
                'sku' => 'BAG-DFL-08',
                'stock' => 12,
                'rating' => 5.0,
                'reviews_count' => 77,
                'badge' => 'HEIRLOOM',
                'featured_image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Leather' => 'Full-Grain Tuscan Vachetta Cowhide',
                    'Dimensions' => '52cm x 28cm x 26cm (42L Capacity)',
                    'Zippers' => 'Swiss Excella Two-Way Brass Zippers',
                    'Lining' => 'Heavyweight 16oz Waxed Canvas',
                ],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'Atacama Handcrafted Acetate Sunglasses',
                'slug' => 'atacama-handcrafted-acetate-sunglasses',
                'short_description' => 'Mazzucchelli bio-acetate frame with polarized Zeiss mineral glass.',
                'description' => 'Sculpted from 8mm thick Italian Mazzucchelli bio-acetate with custom 5-barrel hinges and anti-reflective Zeiss mineral lenses providing 100% UVA/UVB protection.',
                'price' => 220.00,
                'original_price' => 260.00,
                'sku' => 'ACC-SNG-09',
                'stock' => 28,
                'rating' => 4.7,
                'reviews_count' => 42,
                'badge' => 'LIMITED',
                'featured_image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=900&q=80',
                'specs' => [
                    'Frame' => 'Mazzucchelli 1849 Bio-Cellulose Acetate',
                    'Lenses' => 'Carl Zeiss Polarized Green Mineral Glass',
                    'Protection' => 'Category 3 - 100% UV400 Protection',
                    'Hinges' => 'Custom 5-Barrel German Riveted Hinges',
                ],
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $item) {
            $catSlug = $item['category_slug'];
            unset($item['category_slug']);

            if (isset($categories[$catSlug])) {
                $item['category_id'] = $categories[$catSlug]->id;
                Product::updateOrCreate(['slug' => $item['slug']], $item);
            }
        }
    }
}
