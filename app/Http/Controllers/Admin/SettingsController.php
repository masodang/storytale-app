<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller {
    private array $defaults = [
        'brand'   => ['name'=>'STORYTALE','tagline'=>'Stories That Sell','year'=>'2017','location'=>'Jakarta, ID'],
        'ticker_header'  => ['items'=>['★ Stories That Sell','★ Digital Marketing','★ Portfolio 2026','★ Content × Strategy']],
        'ticker_hero'    => ['items'=>['Social Media','Content Marketing','Paid Ads','SEO','Email Marketing','Branding']],
        'ticker_clients' => ['items'=>['NIKE','SPOTIFY','ADOBE','STRIPE','FIGMA','NOTION']],
        'contact' => [
            'email'=>'hello@storytale.id','phone'=>'+62 812-3456-7890','whatsapp'=>'6281234567890',
            'address'=>'Jl. Kemang Raya No. 12, Jakarta Selatan, 12730, Indonesia',
            'instagram_url'=>'https://instagram.com/storytale.id',
            'tiktok_url'=>'https://tiktok.com/@storytale.id',
            'linkedin_url'=>'https://linkedin.com/company/storytale',
        ],
        'hero' => [
            'headline_1'=>'WE','headline_2'=>'TELL','headline_3'=>'YOUR STORY.',
            'description'=>'We are a digital marketing agency that builds bold brand narratives — digital ads, rich media, video, websites, CRM, and AI-powered apps engineered to grow your audience and convert.',
            'stat_projects'=>'87','stat_years'=>'6+','stat_awards'=>'★4',
        ],
        'studio' => [
            'hero_heading'=>'OUR STUDIO',
            'hero_sub'=>'Jakarta, ID — Est. 2017',
            'mission_quote'=>'We don\'t make content. We build stories that sell.',
            'mission_desc'=>'STORYTALE is a Jakarta-based digital marketing agency built on one belief: the right story, told the right way, sells anything. We combine data-driven strategy with bold creative execution.',
            'founded_text'=>'Founded in 2017, we\'ve helped brands across Indonesia cut through the noise.',
            'stats'=>[
                ['val'=>'87','label'=>'Projects Delivered'],
                ['val'=>'6+','label'=>'Years Active'],
                ['val'=>'8','label'=>'Disciplines'],
                ['val'=>'★4','label'=>'Industry Awards'],
            ],
            'process'=>[
                ['num'=>'01','title'=>'Discover','desc'=>'We dive deep into your brand, audience, and competitive landscape to understand what makes you different.'],
                ['num'=>'02','title'=>'Strategise','desc'=>'We build a data-backed plan across the right channels with clear KPIs and a 12-month roadmap.'],
                ['num'=>'03','title'=>'Execute','desc'=>'We produce and deploy across every touchpoint — on brand, on time, on budget, every time.'],
                ['num'=>'04','title'=>'Measure','desc'=>'We track, report, and optimise continuously so every campaign compounds on the last.'],
            ],
        ],
        'footer'  => ['description'=>'Digital Marketing Agency · Est. 2017 · Jakarta, ID','instagram'=>'@storytale.id','tiktok'=>'@storytale.id','linkedin'=>'Storytale Agency'],
        'navbar'  => ['cta_text'=>'Let\'s Talk →','cta_url'=>'#contact'],
    ];

    public function index() {
        $settings = [];
        foreach ($this->defaults as $key => $default) {
            $settings[$key] = SiteSetting::get($key, $default);
        }
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request) {
        foreach ($this->defaults as $key => $default) {
            if (!$request->has($key)) continue;
            $data = $request->input($key);

            // Handle ticker items (textarea → array)
            if (str_starts_with($key, 'ticker_') && isset($data['items_raw'])) {
                $data['items'] = array_values(array_filter(array_map('trim', explode("\n", $data['items_raw']))));
                unset($data['items_raw']);
            }

            // Handle studio stats (repeated fields)
            if ($key === 'studio') {
                $stats = [];
                foreach ((array)($data['stat_val'] ?? []) as $i => $val) {
                    $stats[] = ['val' => trim($val), 'label' => trim($data['stat_label'][$i] ?? '')];
                }
                if ($stats) $data['stats'] = $stats;
                unset($data['stat_val'], $data['stat_label']);

                $steps = [];
                foreach ((array)($data['step_num'] ?? []) as $i => $num) {
                    $steps[] = [
                        'num'   => trim($num),
                        'title' => trim($data['step_title'][$i] ?? ''),
                        'desc'  => trim($data['step_desc'][$i] ?? ''),
                    ];
                }
                if ($steps) $data['process'] = $steps;
                unset($data['step_num'], $data['step_title'], $data['step_desc']);
            }

            SiteSetting::set($key, $data);
        }
        return redirect()->route('admin.settings')->with('success', 'Settings saved.');
    }
}
