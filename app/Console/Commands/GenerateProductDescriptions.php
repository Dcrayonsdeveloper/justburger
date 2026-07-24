<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class GenerateProductDescriptions extends Command
{
    protected $signature = 'products:generate-descriptions {--dry-run : Preview without saving} {--limit=0 : Limit number of products}';
    protected $description = 'Generate SEO descriptions for products that have none';

    public function handle(): int
    {
        $query = Product::whereNull('description')
            ->orWhere('description', '')
            ->with(['category', 'brand']);

        $limit = (int) $this->option('limit');
        if ($limit > 0) {
            $query->limit($limit);
        }

        $total = (clone $query)->count();
        $this->info("Found {$total} products without descriptions.");

        if ($total === 0) {
            return 0;
        }

        $dryRun = $this->option('dry-run');
        $bar = $this->output->createProgressBar($limit > 0 ? min($limit, $total) : $total);
        $updated = 0;

        $query->chunk(500, function ($products) use ($dryRun, $bar, &$updated) {
            foreach ($products as $product) {
                $desc = $this->generateDescription($product);
                $short = $this->generateShortDescription($product);

                if ($dryRun) {
                    if ($updated < 3) {
                        $this->newLine();
                        $this->line("  <fg=cyan>{$product->name}</>");
                        $this->line("  Short: {$short}");
                        $this->line("  Desc:  " . \Illuminate\Support\Str::limit($desc, 120));
                    }
                } else {
                    $product->update([
                        'description' => $desc,
                        'short_description' => $short,
                    ]);
                }

                $updated++;
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);

        if ($dryRun) {
            $this->info("Dry run complete. {$updated} products would be updated.");
        } else {
            $this->info("Done! Updated {$updated} product descriptions.");
        }

        return 0;
    }

    private function generateDescription(Product $product): string
    {
        $name = $product->name;
        $category = $product->category?->name ?? 'General';
        $brand = $product->brand?->name ?? config('app.name', 'JustBurgers');
        $price = number_format($product->price ?? 0);
        $mrp = number_format($product->mrp ?? 0);

        // Detect product type from name
        $type = $this->detectType($name);
        $ageGroup = $this->detectAgeGroup($name);
        $gender = $this->detectGender($name, $category);

        $siteName = \App\Models\Setting::get('site_name', config('app.name'));
        $templates = [
            "Try the {$name} from {$brand} — a delicious choice from our {$category} menu. Made with quality ingredients for a great taste every time. Available at just £{$price}" . ($product->mrp > $product->price ? " (was £{$mrp})" : '') . ". Part of our {$category} menu at {$siteName}.",

            "Enjoy the {$name} by {$brand}. This popular {$category} item is crafted with fresh ingredients for maximum flavour. Perfect for lunch, dinner, or a treat any time. Priced at £{$price}" . ($product->mrp > $product->price ? " (save " . round((($product->mrp - $product->price) / $product->mrp) * 100) . "%!)" : '') . ". Order now at {$siteName} — free delivery on orders above £15.",

            "Introducing the {$name} from {$brand}'s {$category} range. A tasty option that delivers on flavour and quality every time. Available at £{$price}" . ($product->mrp > $product->price ? " — that's " . round((($product->mrp - $product->price) / $product->mrp) * 100) . "% off!" : '') . " Browse more {$category} at {$siteName}.",
        ];

        return $templates[crc32($name) % count($templates)];
    }

    private function generateShortDescription(Product $product): string
    {
        $name = $product->name;
        $brand = $product->brand?->name ?? config('app.name', 'JustBurgers');
        $type = $this->detectType($name);
        $gender = $this->detectGender($name, $product->category?->name ?? '');

        $templates = [
            "Stylish {$type} for {$gender} by {$brand}. Soft, comfortable fabric perfect for everyday wear.",
            "Trendy {$type} from {$brand} — designed for comfort and style. Ideal for {$gender}.",
            "Premium quality {$type} by {$brand}. Breathable, comfortable, and perfect for your little one.",
        ];

        return $templates[crc32($name) % count($templates)];
    }

    private function detectType(string $name): string
    {
        $n = strtolower($name);
        if (preg_match('/\bset\b|combo/', $n)) return 'clothing set';
        if (preg_match('/\bdress\b|frock/', $n)) return 'dress';
        if (preg_match('/\btop\b|tee|t-?shirt/', $n)) return 'top';
        if (preg_match('/\bshirt\b/', $n)) return 'shirt';
        if (preg_match('/\blower\b|pant|jean|trouser|legging|bottom/', $n)) return 'bottom wear';
        if (preg_match('/\bkurta\b|ethnic|sherwani/', $n)) return 'ethnic wear';
        if (preg_match('/\bjacket\b|sweater|hoodie|sweatshirt/', $n)) return 'winter wear';
        if (preg_match('/\bshoe|sandal|slipper|sneaker/', $n)) return 'footwear';
        if (preg_match('/\bbag|backpack/', $n)) return 'bag';
        if (preg_match('/\bromper|bodysuit|onesie/', $n)) return 'romper';
        if (preg_match('/\bshort\b/', $n)) return 'shorts';
        if (preg_match('/\bskirt\b/', $n)) return 'skirt';
        if (preg_match('/\bjumpsuit\b/', $n)) return 'jumpsuit';
        if (preg_match('/\bsock\b|innerwear|brief|vest/', $n)) return 'innerwear';
        return 'outfit';
    }

    private function detectAgeGroup(string $name): string
    {
        $n = strtolower($name);
        if (preg_match('/\bbaby\b|infant|newborn|0-/', $n)) return 'babies and toddlers';
        if (preg_match('/\btoddler\b|1-|2-/', $n)) return 'toddlers';
        if (preg_match('/\bjunior\b|teen/', $n)) return 'juniors and teens';
        return 'kids of all ages';
    }

    private function detectGender(string $name, string $category): string
    {
        $n = strtolower($name . ' ' . $category);
        if (preg_match('/\bgirl|girls\b/', $n)) return 'girls';
        if (preg_match('/\bboy|boys\b/', $n)) return 'boys';
        return 'kids';
    }
}
