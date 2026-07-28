<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JustBurgersSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedBrand();
        $this->seedCategories();
        $this->seedProducts();

        $this->command->info('Just Burgers Plus seeder completed successfully.');
    }

    // ─── Settings ────────────────────────────────────────────────────

    private function seedSettings(): void
    {
        $settings = [
            // General
            ['group' => 'general', 'key' => 'site_name',           'value' => 'Just Burgers Plus',                                                      'type' => 'string'],
            ['group' => 'general', 'key' => 'site_tagline',        'value' => 'Charbroiled Burgers Since 1989',                                          'type' => 'string'],
            ['group' => 'general', 'key' => 'site_email',          'value' => 'justburgersplus@gmail.com',                                                   'type' => 'string'],
            ['group' => 'general', 'key' => 'site_phone',          'value' => '02088905008',                                                         'type' => 'string'],
            ['group' => 'general', 'key' => 'site_mobile',         'value' => '07368998035',                                                        'type' => 'string'],
            ['group' => 'general', 'key' => 'site_whatsapp',       'value' => '447368998035',                                                            'type' => 'string'],
            ['group' => 'general', 'key' => 'site_address',        'value' => '525 Staines Road, Bedfont, Middx. TW14 8BP',                              'type' => 'string'],
            ['group' => 'general', 'key' => 'timezone',            'value' => 'Europe/London',                                                           'type' => 'string'],
            ['group' => 'general', 'key' => 'date_format',         'value' => 'd M Y',                                                                   'type' => 'string'],
            ['group' => 'general', 'key' => 'currency',            'value' => 'GBP',                                                                     'type' => 'string'],
            ['group' => 'general', 'key' => 'currency_symbol',     'value' => '£',                                                                       'type' => 'string'],
            ['group' => 'general', 'key' => 'currency_position',   'value' => 'before',                                                                  'type' => 'string'],
            ['group' => 'general', 'key' => 'announcement_text',   'value' => 'TELEPHONE ORDERS WELCOME — CALL 02088905008',                         'type' => 'string'],
            ['group' => 'general', 'key' => 'footer_about',        'value' => 'Just Burgers Plus has been serving charbroiled burgers in Feltham since 1989. We have no other branch. Telephone orders welcome.',  'type' => 'string'],
            ['group' => 'general', 'key' => 'wholesale_enabled',   'value' => '0',                                                                       'type' => 'boolean'],
            ['group' => 'general', 'key' => 'established_year',    'value' => '1989',                                                                    'type' => 'string'],

            // Opening Hours
            ['group' => 'general', 'key' => 'opening_hours_mon',   'value' => '12:00 PM – 10:00 PM',   'type' => 'string'],
            ['group' => 'general', 'key' => 'opening_hours_tue',   'value' => '12:00 PM – 10:00 PM',   'type' => 'string'],
            ['group' => 'general', 'key' => 'opening_hours_wed',   'value' => '12:00 PM – 10:30 PM',  'type' => 'string'],
            ['group' => 'general', 'key' => 'opening_hours_thu',   'value' => '12:00 PM – 10:30 PM',  'type' => 'string'],
            ['group' => 'general', 'key' => 'opening_hours_fri',   'value' => '11:45 AM – 11:00 PM',  'type' => 'string'],
            ['group' => 'general', 'key' => 'opening_hours_sat',   'value' => '11:45 AM – 11:00 PM',  'type' => 'string'],
            ['group' => 'general', 'key' => 'opening_hours_sun',   'value' => '4:00 PM – 10:00 PM',   'type' => 'string'],

            // Payment
            ['group' => 'payment', 'key' => 'stripe_enabled',      'value' => '0', 'type' => 'boolean'],
            ['group' => 'payment', 'key' => 'paypal_enabled',      'value' => '0', 'type' => 'boolean'],
            ['group' => 'payment', 'key' => 'paypal_mode',         'value' => 'sandbox', 'type' => 'string'],
            ['group' => 'payment', 'key' => 'cod_enabled',         'value' => '1', 'type' => 'boolean'],
            ['group' => 'payment', 'key' => 'upi_enabled',         'value' => '0', 'type' => 'boolean'],

            // Delivery
            ['group' => 'shipping', 'key' => 'free_shipping_enabled',    'value' => '0',    'type' => 'boolean'],
            ['group' => 'shipping', 'key' => 'free_shipping_threshold',  'value' => '20',   'type' => 'integer'],
            ['group' => 'shipping', 'key' => 'flat_rate_enabled',        'value' => '1',    'type' => 'boolean'],
            ['group' => 'shipping', 'key' => 'flat_rate_amount',         'value' => '2.50', 'type' => 'string'],
            ['group' => 'shipping', 'key' => 'local_pickup_enabled',     'value' => '1',    'type' => 'boolean'],
            ['group' => 'shipping', 'key' => 'shipping_origin_country',  'value' => 'GB',   'type' => 'string'],

            // Tax (UK VAT inclusive in food prices)
            ['group' => 'tax', 'key' => 'tax_enabled',       'value' => '1',         'type' => 'boolean'],
            ['group' => 'tax', 'key' => 'tax_calculation',   'value' => 'inclusive',  'type' => 'string'],
            ['group' => 'tax', 'key' => 'tax_based_on',      'value' => 'shipping',   'type' => 'string'],
            ['group' => 'tax', 'key' => 'tax_display_cart',  'value' => 'including',  'type' => 'string'],

            // Email
            ['group' => 'email', 'key' => 'mail_driver',       'value' => 'smtp',                         'type' => 'string'],
            ['group' => 'email', 'key' => 'mail_from_address', 'value' => 'noreply@justburgers.com',      'type' => 'string'],
            ['group' => 'email', 'key' => 'mail_from_name',    'value' => 'Just Burgers Plus',            'type' => 'string'],

            // SEO
            ['group' => 'seo', 'key' => 'meta_title',       'value' => 'Just Burgers Plus — Charbroiled Burgers Since 1989 | Feltham',                                                                              'type' => 'string'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'Just Burgers Plus, 525 Staines Road, Feltham. Charbroiled burgers, chicken burgers, kebab wraps, milkshakes & more. Telephone orders welcome. Established 1989.', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'meta_keywords',    'value' => 'just burgers plus, feltham burgers, charbroiled burgers, chicken burgers, kebab wraps, milkshakes, staines road feltham, takeaway feltham',   'type' => 'string'],

            // Social
            ['group' => 'social', 'key' => 'social_facebook',  'value' => 'https://www.facebook.com/justburgersplus', 'type' => 'string'],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => '#',                                        'type' => 'string'],
            ['group' => 'social', 'key' => 'social_twitter',   'value' => '#',                                        'type' => 'string'],
            ['group' => 'social', 'key' => 'social_youtube',   'value' => '#',                                        'type' => 'string'],
        ];

        DB::table('settings')->insertOrIgnore(
            array_map(function ($s) {
                return array_merge($s, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }, $settings)
        );

        $this->command->info('Settings seeded.');
    }

    // ─── Brand ───────────────────────────────────────────────────────

    private function seedBrand(): void
    {
        DB::table('brands')->insertOrIgnore([
            'name'        => 'Just Burgers Plus',
            'slug'        => 'just-burgers-plus',
            'description' => 'Just Burgers Plus — charbroiled burgers, chicken burgers, vegetarian options, kebab wraps, milkshakes and more. Serving Feltham since 1989. We have no other branch.',
            'logo_url'    => '/images/brand/justburgers-logo.png',
            'website_url' => 'https://justburgers.com',
            'is_active'   => true,
            'is_featured' => true,
            'position'    => 0,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $this->command->info('Brand seeded.');
    }

    // ─── Categories ──────────────────────────────────────────────────

    private function seedCategories(): void
    {
        $categories = [
            [
                'name'        => 'Burgers',
                'description' => 'Charbroiled beef burgers, all served with fries',
                'icon'        => 'flame',
                'is_featured' => true,
            ],
            [
                'name'        => 'Chicken Burgers',
                'description' => 'Chicken fillet burgers with fries',
                'icon'        => 'drumstick',
                'is_featured' => true,
            ],
            [
                'name'        => 'Chicken Strips',
                'description' => 'Crispy chicken strips served with fries',
                'icon'        => 'drumstick',
                'is_featured' => true,
            ],
            [
                'name'        => 'Vegetarian',
                'description' => 'Meat-free burgers served with fries',
                'icon'        => 'leaf',
                'is_featured' => true,
            ],
            [
                'name'        => 'Kids Meals',
                'description' => 'Smaller portions for the little ones',
                'icon'        => 'star',
                'is_featured' => true,
            ],
            [
                'name'        => 'Kebab Wraps',
                'description' => 'Freshly made lamb and chicken kebab wraps',
                'icon'        => 'flame',
                'is_featured' => true,
            ],
            [
                'name'        => 'Chicken Wings',
                'description' => 'Crispy golden chicken wings',
                'icon'        => 'drumstick',
                'is_featured' => true,
            ],
            [
                'name'        => 'Milkshakes',
                'description' => 'Thick, indulgent milkshakes',
                'icon'        => 'cup-straw',
                'is_featured' => true,
            ],
            [
                'name'        => 'Sides & Extras',
                'description' => 'Add-ons, sides and sauces',
                'icon'        => 'fries',
                'is_featured' => true,
            ],
            [
                'name'        => 'Family Meals',
                'description' => 'Great value meal deals for the whole family',
                'icon'        => 'basket',
                'is_featured' => false,
            ],
        ];

        $position = 1;
        foreach ($categories as $cat) {
            DB::table('categories')->insertOrIgnore([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
                'icon'        => $cat['icon'],
                'position'    => $position++,
                'is_active'   => true,
                'is_featured' => $cat['is_featured'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('Categories seeded (' . count($categories) . ').');
    }

    // ─── Products ────────────────────────────────────────────────────

    private function seedProducts(): void
    {
        $catId = fn (string $slug) => DB::table('categories')
            ->where('slug', $slug)
            ->value('id');

        $brandId = DB::table('brands')->where('slug', 'just-burgers-plus')->value('id');

        $products = [

            // ── Burgers (charbroiled, all served with fries) ──────────

            [
                'name'              => 'Cheese Burger',
                'short_description' => 'Classic charbroiled beef burger with melted cheese, served with fries.',
                'description'       => 'Our classic Cheese Burger — a charbroiled beef patty topped with melted cheese, fresh lettuce, tomato, and onion in a toasted sesame bun. Served with a generous portion of fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-001',
                'price'             => 6.50,
                'mrp'               => 6.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Garlic Burger',
                'short_description' => 'Charbroiled beef burger with garlic mayo, served with fries.',
                'description'       => 'Charbroiled beef patty loaded with our creamy garlic mayo sauce, fresh salad, and served in a toasted bun with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-002',
                'price'             => 6.50,
                'mrp'               => 6.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'BBQ Burger',
                'short_description' => 'Charbroiled beef burger with smoky BBQ sauce, served with fries.',
                'description'       => 'Charbroiled beef patty smothered in our tangy BBQ sauce with crispy onion rings, lettuce, and melted cheese. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-003',
                'price'             => 6.90,
                'mrp'               => 6.90,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Mexican Burger',
                'short_description' => 'Spicy charbroiled burger with jalapenos and Mexican sauce, with fries.',
                'description'       => 'Charbroiled beef patty with spicy Mexican sauce, jalapenos, melted pepper jack cheese, and fresh salad. Served with fries. Brings the heat!',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-004',
                'price'             => 7.20,
                'mrp'               => 7.20,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Gangsta Burger',
                'short_description' => 'Loaded charbroiled burger with all the fixings, served with fries.',
                'description'       => 'Our signature Gangsta Burger — a charbroiled beef patty stacked with double cheese, bacon, onion rings, and our house sauce. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-005',
                'price'             => 7.20,
                'mrp'               => 8.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Bronx Burger',
                'short_description' => 'Bold and smoky charbroiled burger, served with fries.',
                'description'       => 'The Bronx — a charbroiled beef patty with smoked cheese, crispy bacon, BBQ sauce, and fresh salad in a toasted bun. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-006',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Hawaiian Burger',
                'short_description' => 'Charbroiled burger with grilled pineapple, served with fries.',
                'description'       => 'Charbroiled beef patty topped with a grilled pineapple ring, melted cheese, and sweet chilli sauce. A tropical twist on a classic. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-007',
                'price'             => 7.50,
                'mrp'               => 8.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Louisiana Burger',
                'short_description' => 'Cajun-spiced charbroiled burger, served with fries.',
                'description'       => 'Charbroiled beef patty seasoned with Cajun spices, topped with pepper jack cheese, crispy onions, and Louisiana hot sauce. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-008',
                'price'             => 7.50,
                'mrp'               => 8.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Malibu Burger',
                'short_description' => 'Charbroiled burger with a West Coast twist, served with fries.',
                'description'       => 'Charbroiled beef patty with avocado, melted Swiss cheese, crispy bacon, and a zesty lime mayo. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-009',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Manhattan Burger',
                'short_description' => 'Premium charbroiled burger loaded New York style, with fries.',
                'description'       => 'The Manhattan — a charbroiled beef patty with pastrami, melted Swiss, pickles, and American mustard on a toasted bun. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-010',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Nashville Burger',
                'short_description' => 'Hot and spicy Nashville-style charbroiled burger, with fries.',
                'description'       => 'Charbroiled beef patty drenched in fiery Nashville hot sauce, topped with coleslaw and pickles for the perfect balance of heat and cool. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-011',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Monster Burger',
                'short_description' => 'Double-patty charbroiled beast of a burger, served with fries.',
                'description'       => 'The Monster — two charbroiled beef patties, double cheese, bacon, onion rings, lettuce, tomato, and our special monster sauce. Not for the faint-hearted. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-012',
                'price'             => 7.50,
                'mrp'               => 8.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'New Yorker Smash',
                'short_description' => 'Smash-style charbroiled burger, served with fries.',
                'description'       => 'New Yorker Smash — thin smashed patties with melted cheese, pickles, onions, and our house smash sauce. Real street-food style. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-013',
                'price'             => 7.50,
                'mrp'               => 8.85,
                'is_featured'       => true,
            ],
            [
                'name'              => 'California Dreamer',
                'short_description' => 'West Coast inspired charbroiled burger, served with fries.',
                'description'       => 'The California Dreamer — charbroiled beef patty with guacamole, crispy bacon, Swiss cheese, fresh tomato and lettuce. Sunshine on a bun. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-014',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'LA Smash',
                'short_description' => 'Double smash patty burger LA style, served with fries.',
                'description'       => 'LA Smash — two thin smashed beef patties with American cheese, caramelised onions, pickles, and our signature LA sauce. Served with fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-015',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Fish Burger',
                'short_description' => 'Crispy battered fish fillet burger, served with fries.',
                'description'       => 'Golden battered fish fillet in a soft bun with tartare sauce, lettuce and a lemon wedge. Served with a generous portion of fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-016',
                'price'             => 7.20,
                'mrp'               => 7.20,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Ribs with Fries',
                'short_description' => 'Smoky BBQ ribs served with fries.',
                'description'       => 'Tender, fall-off-the-bone BBQ ribs glazed with our house smoky sauce. Served with a generous portion of fries.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-017',
                'price'             => 8.85,
                'mrp'               => 8.85,
                'is_featured'       => false,
            ],

            // ── Chicken Fillet Burgers (with fries) ──────────────────

            [
                'name'              => 'Dixie Chicken Burger',
                'short_description' => 'Southern-style crispy chicken fillet burger with fries.',
                'description'       => 'Dixie — crispy fried chicken fillet with mayo, lettuce, and tomato in a toasted bun. A classic Southern-style chicken burger. Served with fries.',
                'category_slug'     => 'chicken-burgers',
                'sku'               => 'JBP-018',
                'price'             => 6.90,
                'mrp'               => 8.18,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Eastside Chicken Burger',
                'short_description' => 'Spiced chicken fillet burger, served with fries.',
                'description'       => 'Eastside — crispy chicken fillet with spiced mayo, pickled slaw, and crunchy lettuce. Served with fries.',
                'category_slug'     => 'chicken-burgers',
                'sku'               => 'JBP-019',
                'price'             => 7.29,
                'mrp'               => 7.29,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Northside Chicken Burger',
                'short_description' => 'Loaded chicken fillet burger with all the toppings, with fries.',
                'description'       => 'Northside — crispy chicken fillet loaded with cheese, bacon, and our signature sauce. Served with fries.',
                'category_slug'     => 'chicken-burgers',
                'sku'               => 'JBP-020',
                'price'             => 7.29,
                'mrp'               => 7.29,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Chicken Monster Burger',
                'short_description' => 'Double chicken fillet burger stacked high, with fries.',
                'description'       => 'Chicken Monster — double crispy chicken fillets, double cheese, bacon, lettuce, and our monster sauce. A towering chicken creation. Served with fries.',
                'category_slug'     => 'chicken-burgers',
                'sku'               => 'JBP-021',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Hellfire Chicken Burger',
                'short_description' => 'Extra hot and spicy chicken fillet burger, with fries.',
                'description'       => 'Hellfire — crispy chicken fillet drenched in our blazing hot sauce with jalapenos, pepper jack cheese, and cooling ranch. For those who dare. Served with fries.',
                'category_slug'     => 'chicken-burgers',
                'sku'               => 'JBP-022',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Miami Hot Chicken Burger',
                'short_description' => 'Miami-style hot chicken fillet burger, served with fries.',
                'description'       => 'Miami Hot — crispy chicken fillet with spicy Miami sauce, fresh slaw, and pickles. Bold, hot, and full of flavour. Served with fries.',
                'category_slug'     => 'chicken-burgers',
                'sku'               => 'JBP-023',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => true,
            ],

            // ── Chicken Strips ───────────────────────────────────────

            [
                'name'              => 'Chicken Strips with Fries',
                'short_description' => 'Crispy golden chicken strips served with fries.',
                'description'       => 'Tender chicken breast strips coated in our crispy seasoned batter, fried until golden. Served with a generous portion of fries and your choice of dipping sauce.',
                'category_slug'     => 'chicken-strips',
                'sku'               => 'JBP-024',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Chicken Strips Combo',
                'short_description' => 'Chicken strips, fries, drink and dip — complete meal.',
                'description'       => 'Our chicken strips combo — crispy chicken strips with fries, a drink, and your choice of dipping sauce. The complete meal deal.',
                'category_slug'     => 'chicken-strips',
                'sku'               => 'JBP-025',
                'price'             => 8.50,
                'mrp'               => 8.50,
                'is_featured'       => true,
            ],

            // ── Vegetarian ───────────────────────────────────────────

            [
                'name'              => 'Soya Burger',
                'short_description' => 'Soya bean patty burger with fresh salad, served with fries.',
                'description'       => 'Our vegetarian Soya Burger — a seasoned soya bean patty with lettuce, tomato, onion, and mayo in a toasted bun. Served with fries.',
                'category_slug'     => 'vegetarian',
                'sku'               => 'JBP-026',
                'price'             => 7.00,
                'mrp'               => 7.00,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Halloumi Cheese Burger',
                'short_description' => 'Grilled halloumi cheese burger with fresh salad, served with fries.',
                'description'       => 'Thick slices of grilled halloumi cheese with fresh lettuce, tomato, cucumber, and a drizzle of sweet chilli sauce. Served with fries.',
                'category_slug'     => 'vegetarian',
                'sku'               => 'JBP-027',
                'price'             => 7.00,
                'mrp'               => 7.00,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Spicy Bean Burger',
                'short_description' => 'Spiced bean patty burger, served with fries.',
                'description'       => 'A hearty spiced bean patty with mixed peppers, onion, and our spicy mayo. Topped with fresh salad in a toasted bun. Served with fries.',
                'category_slug'     => 'vegetarian',
                'sku'               => 'JBP-028',
                'price'             => 7.00,
                'mrp'               => 7.00,
                'is_featured'       => false,
            ],

            // ── Kids Meals ───────────────────────────────────────────

            [
                'name'              => 'Kids Chicken Nuggets & Fries',
                'short_description' => 'Chicken nuggets with fries — perfect for little ones.',
                'description'       => 'Bite-sized crispy chicken nuggets served with a kids portion of fries. A favourite with the little ones.',
                'category_slug'     => 'kids-meals',
                'sku'               => 'JBP-029',
                'price'             => 4.00,
                'mrp'               => 4.00,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Kids Chicken Strips & Fries',
                'short_description' => 'Chicken strips with fries — kids portion.',
                'description'       => 'Crispy chicken strips served with a kids portion of fries and a dipping sauce.',
                'category_slug'     => 'kids-meals',
                'sku'               => 'JBP-030',
                'price'             => 4.50,
                'mrp'               => 4.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Kids Cheese Burger & Fries',
                'short_description' => 'Mini cheese burger with fries — kids portion.',
                'description'       => 'A smaller charbroiled cheese burger with fries. Just the right size for hungry kids.',
                'category_slug'     => 'kids-meals',
                'sku'               => 'JBP-031',
                'price'             => 4.50,
                'mrp'               => 4.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Kids Chicken Burger & Fries',
                'short_description' => 'Mini chicken burger with fries and dip — kids portion.',
                'description'       => 'A smaller crispy chicken burger with fries and a choice of dipping sauce.',
                'category_slug'     => 'kids-meals',
                'sku'               => 'JBP-032',
                'price'             => 4.50,
                'mrp'               => 4.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Kids Fish Fingers & Fries',
                'short_description' => 'Crispy fish fingers with fries — kids portion.',
                'description'       => 'Golden crispy fish fingers with a kids portion of fries.',
                'category_slug'     => 'kids-meals',
                'sku'               => 'JBP-033',
                'price'             => 4.50,
                'mrp'               => 4.50,
                'is_featured'       => false,
            ],

            // ── Kebab Wraps ──────────────────────────────────────────

            [
                'name'              => 'Lamb Kebab Wrap',
                'short_description' => 'Tender lamb doner in a warm wrap with fresh salad.',
                'description'       => 'Thinly sliced tender lamb doner wrapped in a warm tortilla with fresh salad, onions, and our garlic or chilli sauce.',
                'category_slug'     => 'kebab-wraps',
                'sku'               => 'JBP-034',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Chicken Kebab Wrap',
                'short_description' => 'Grilled chicken doner in a warm wrap with fresh salad.',
                'description'       => 'Seasoned grilled chicken doner wrapped in a warm tortilla with fresh salad, onions, and your choice of sauce.',
                'category_slug'     => 'kebab-wraps',
                'sku'               => 'JBP-035',
                'price'             => 7.50,
                'mrp'               => 7.50,
                'is_featured'       => true,
            ],

            // ── Chicken Wings ────────────────────────────────────────

            [
                'name'              => '6 Chicken Wings',
                'short_description' => '6 crispy golden chicken wings.',
                'description'       => '6 crispy chicken wings seasoned and fried to golden perfection. Choice of plain, BBQ, or hot sauce.',
                'category_slug'     => 'chicken-wings',
                'sku'               => 'JBP-036',
                'price'             => 3.99,
                'mrp'               => 3.99,
                'is_featured'       => true,
            ],
            [
                'name'              => '10 Chicken Wings',
                'short_description' => '10 crispy golden chicken wings — great for sharing.',
                'description'       => '10 crispy chicken wings — plain, BBQ, or hot sauce. Perfect for sharing or a hungry appetite.',
                'category_slug'     => 'chicken-wings',
                'sku'               => 'JBP-037',
                'price'             => 5.99,
                'mrp'               => 5.99,
                'is_featured'       => true,
            ],

            // ── Milkshakes (all £5.00) ───────────────────────────────

            [
                'name'              => 'Strawberry Milkshake',
                'short_description' => 'Thick and creamy strawberry milkshake.',
                'description'       => 'Thick, creamy strawberry milkshake made with real strawberry ice cream and whole milk. The perfect sweet treat.',
                'category_slug'     => 'milkshakes',
                'sku'               => 'JBP-038',
                'price'             => 5.00,
                'mrp'               => 5.00,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Biscoff Dream Milkshake',
                'short_description' => 'Indulgent Lotus Biscoff milkshake.',
                'description'       => 'Our Biscoff Dream — a thick, indulgent milkshake blended with Lotus Biscoff spread and crushed biscuit pieces. Dreamy, spiced, and utterly addictive.',
                'category_slug'     => 'milkshakes',
                'sku'               => 'JBP-039',
                'price'             => 5.00,
                'mrp'               => 5.00,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Chocolate Milkshake',
                'short_description' => 'Rich and creamy chocolate milkshake.',
                'description'       => 'Classic thick chocolate milkshake made with premium chocolate ice cream and a swirl of chocolate sauce.',
                'category_slug'     => 'milkshakes',
                'sku'               => 'JBP-040',
                'price'             => 5.00,
                'mrp'               => 5.00,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Oreo Deluxe Milkshake',
                'short_description' => 'Cookies and cream Oreo milkshake.',
                'description'       => 'Oreo Deluxe — vanilla milkshake blended with crushed Oreo cookies. Thick, crunchy, and irresistible.',
                'category_slug'     => 'milkshakes',
                'sku'               => 'JBP-041',
                'price'             => 5.00,
                'mrp'               => 5.00,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Vanilla Classic Milkshake',
                'short_description' => 'Traditional vanilla milkshake made with real vanilla.',
                'description'       => 'A timeless classic — smooth, creamy vanilla milkshake made with real vanilla ice cream.',
                'category_slug'     => 'milkshakes',
                'sku'               => 'JBP-042',
                'price'             => 5.00,
                'mrp'               => 5.00,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Brilliant Bueno Milkshake',
                'short_description' => 'Kinder Bueno inspired milkshake — hazelnut and chocolate.',
                'description'       => 'Brilliant Bueno — a rich, nutty milkshake inspired by Kinder Bueno, blended with hazelnut and chocolate. Pure indulgence.',
                'category_slug'     => 'milkshakes',
                'sku'               => 'JBP-043',
                'price'             => 5.00,
                'mrp'               => 5.00,
                'is_featured'       => true,
            ],

            // ── Sides & Extras ───────────────────────────────────────

            [
                'name'              => 'Poppy Chicken (Small)',
                'short_description' => 'Bite-sized popcorn chicken — small portion.',
                'description'       => 'Crispy, bite-sized pieces of seasoned chicken. Golden and crunchy — perfect as a snack or side.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-044',
                'price'             => 2.26,
                'mrp'               => 2.26,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Poppy Chicken (Large)',
                'short_description' => 'Bite-sized popcorn chicken — large portion.',
                'description'       => 'A generous large portion of our crispy, seasoned popcorn chicken bites.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-045',
                'price'             => 4.26,
                'mrp'               => 4.26,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Chilli Cheese Nuggets',
                'short_description' => 'Crispy nuggets filled with chilli cheese.',
                'description'       => 'Crispy breaded nuggets oozing with spicy chilli cheese. A fiery, cheesy snack.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-046',
                'price'             => 3.50,
                'mrp'               => 3.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Onion Rings',
                'short_description' => 'Crispy battered onion rings.',
                'description'       => 'Thick-cut onion rings coated in a light, crispy batter. Golden fried to perfection.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-047',
                'price'             => 2.50,
                'mrp'               => 2.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Cream Garlic Mushrooms',
                'short_description' => 'Creamy garlic mushrooms.',
                'description'       => 'Button mushrooms sautéed in a rich, creamy garlic sauce.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-048',
                'price'             => 2.50,
                'mrp'               => 2.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Coleslaw',
                'short_description' => 'Freshly made creamy coleslaw.',
                'description'       => 'Creamy, crunchy coleslaw made fresh daily. The perfect side to any burger.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-049',
                'price'             => 1.50,
                'mrp'               => 1.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Garlic Fries',
                'short_description' => 'Crispy fries tossed in garlic butter.',
                'description'       => 'Golden fries tossed in garlic butter and herbs. Irresistibly moreish.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-050',
                'price'             => 3.50,
                'mrp'               => 3.50,
                'is_featured'       => true,
            ],
            [
                'name'              => 'Garlic Bread',
                'short_description' => 'Warm garlic bread.',
                'description'       => 'Warm, toasted garlic bread with garlic butter spread.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-051',
                'price'             => 2.50,
                'mrp'               => 2.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Extra Side Fries',
                'short_description' => 'Extra large portion of crispy fries.',
                'description'       => 'An extra-large portion of our golden, crispy fries. Perfect for sharing or when you just need more fries.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-052',
                'price'             => 2.50,
                'mrp'               => 2.50,
                'is_featured'       => false,
            ],
            [
                'name'              => 'Cheesecake',
                'short_description' => 'Creamy cheesecake slice.',
                'description'       => 'A generous slice of smooth, creamy cheesecake. The perfect sweet finish.',
                'category_slug'     => 'sides-extras',
                'sku'               => 'JBP-053',
                'price'             => 3.50,
                'mrp'               => 3.50,
                'is_featured'       => false,
            ],

            // ── Family Meals ─────────────────────────────────────────

            [
                'name'              => 'Regular Family Meal',
                'short_description' => 'Family meal deal — burgers, fries and drinks for the family.',
                'description'       => 'Our Regular Family Meal — a great value deal with burgers, a large portion of fries, and drinks. Perfect for feeding the whole family.',
                'category_slug'     => 'family-meals',
                'sku'               => 'JBP-054',
                'price'             => 19.99,
                'mrp'               => 24.00,
                'is_featured'       => true,
            ],

            // ── Lunchtime Deal ───────────────────────────────────────

            [
                'name'              => 'Lunchtime Burger Deal',
                'short_description' => 'Any burger with fries — lunchtime special price.',
                'description'       => 'Our famous Lunchtime Burger Deal — choose any burger from the menu served with fries at a special price. Available during lunch hours.',
                'category_slug'     => 'burgers',
                'sku'               => 'JBP-055',
                'price'             => 5.50,
                'mrp'               => 6.50,
                'is_featured'       => true,
            ],
        ];

        $productCount = 0;
        $imageCount   = 0;

        foreach ($products as $index => $p) {
            $categoryId = $catId($p['category_slug']);

            if (! $categoryId) {
                $this->command->warn("Category '{$p['category_slug']}' not found, skipping product '{$p['name']}'.");
                continue;
            }

            $slug = Str::slug($p['name']);

            // Skip if product already exists
            if (DB::table('products')->where('slug', $slug)->exists()) {
                continue;
            }

            $productId = DB::table('products')->insertGetId([
                'uuid'              => (string) Str::uuid(),
                'seller_id'         => null,
                'brand_id'          => $brandId,
                'category_id'       => $categoryId,
                'name'              => $p['name'],
                'slug'              => $slug,
                'short_description' => $p['short_description'],
                'description'       => $p['description'],
                'sku'               => $p['sku'],
                'barcode'           => null,
                'mrp'               => $p['mrp'],
                'price'             => $p['price'],
                'cost_price'        => round($p['price'] * 0.40, 2),
                'stock_quantity'    => 999,
                'low_stock_threshold' => 10,
                'stock_status'      => 'in_stock',
                'weight'            => null,
                'weight_unit'       => 'g',
                'dimension_unit'    => 'cm',
                'is_active'         => true,
                'is_featured'       => $p['is_featured'],
                'is_taxable'        => true,
                'tax_rate'          => 20.00,
                'rating'            => 0,
                'review_count'      => 0,
                'view_count'        => 0,
                'sales_count'       => 0,
                'wishlist_count'    => 0,
                'status'            => 'approved',
                'published_at'      => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // Create a primary product image
            $imageNumber = $index + 1;
            DB::table('product_images')->insert([
                'product_id' => $productId,
                'url'        => "/images/products/product-{$imageNumber}.jpg",
                'alt_text'   => $p['name'],
                'position'   => 0,
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productCount++;
            $imageCount++;
        }

        $this->command->info("Products seeded ({$productCount}). Images created ({$imageCount}).");
    }
}
