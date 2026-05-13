<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;

class ApiController extends Controller
{
    public function journals()
    {
        return response()->json(Journal::published()->get());
    }

    public function settings()
    {
        $S = SiteSetting::class;
        return response()->json([
            'brand'          => $S::get('brand',          ['name'=>'STORYTALE','tagline'=>'Stories That Sell','year'=>'2017','location'=>'Jakarta, ID']),
            'ticker_header'  => $S::get('ticker_header',  ['items'=>['★ Stories That Sell','★ Digital Marketing','★ Portfolio 2026','★ Content × Strategy']]),
            'ticker_hero'    => $S::get('ticker_hero',    ['items'=>['Social Media','Content Marketing','Paid Ads','SEO','Email Marketing','Branding']]),
            'ticker_clients' => $S::get('ticker_clients', ['items'=>['NIKE','SPOTIFY','ADOBE','STRIPE','FIGMA','NOTION']]),
            'contact'        => $S::get('contact',        ['email'=>'hello@storytale.id','phone'=>'+62 812-3456-7890','whatsapp'=>'6281234567890','address'=>'Jl. Kemang Raya No. 12','instagram_url'=>'#','tiktok_url'=>'#','linkedin_url'=>'#']),
            'hero'           => $S::get('hero',           ['headline_1'=>'WE','headline_2'=>'TELL','headline_3'=>'YOUR STORY.','description'=>'','stat_projects'=>'87','stat_years'=>'6+','stat_awards'=>'★4']),
            'studio'         => $S::get('studio',         ['hero_heading'=>'OUR STUDIO','hero_sub'=>'Jakarta, ID — Est. 2017','mission_quote'=>'We don\'t make content. We build stories that sell.','mission_desc'=>'','founded_text'=>'','stats'=>[],'process'=>[]]),
            'footer'         => $S::get('footer',         ['description'=>'Digital Marketing Agency · Est. 2017 · Jakarta, ID','instagram'=>'@storytale.id','tiktok'=>'@storytale.id','linkedin'=>'Storytale Agency']),
            'navbar'         => $S::get('navbar',         ['cta_text'=>"Let's Talk →",'cta_url'=>'#contact']),
        ]);
    }

    public function services()
    {
        return response()->json(Service::active()->get());
    }

    public function team()
    {
        return response()->json(TeamMember::where('is_active', true)->orderBy('sort_order')->get());
    }

    public function projects()
    {
        return response()->json(
            Project::with('category')
                ->where('status', 'published')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->get()
                ->map(fn($p) => [
                    'id'           => $p->id,
                    'title'        => $p->title,
                    'slug'         => $p->slug,
                    'client'       => $p->client,
                    'project_year' => $p->project_year,
                    'cover_image'  => $p->cover_image,
                    'is_featured'  => $p->is_featured,
                    'category'     => $p->category ? ['name' => $p->category->name, 'color' => $p->category->color] : null,
                ])
        );
    }
}
