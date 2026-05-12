<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;
use App\Models\ProjectCategory;
use App\Models\Project;
use App\Models\BlogTag;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Journal;
use App\Models\Service;

class StoryTaleSeeder extends Seeder
{
    public function run(): void
    {
        // Team
        $andi  = TeamMember::create(['name' => 'Andi Pratama',  'role' => 'Founder & Creative Director', 'bio' => '10+ years building bold brand narratives for regional and global clients.', 'email' => 'andi@storytale.id',  'instagram' => '@andipratama',  'linkedin' => 'linkedin.com/in/andipratama',  'sort_order' => 1]);
        $sari  = TeamMember::create(['name' => 'Sari Dewi',     'role' => 'Head of Content Strategy',    'bio' => 'Turns complex briefs into scroll-stopping stories across every platform.',  'email' => 'sari@storytale.id',  'instagram' => '@saridewi',     'linkedin' => 'linkedin.com/in/saridewi',     'sort_order' => 2]);
        $rizky = TeamMember::create(['name' => 'Rizky Maulana', 'role' => 'Paid Media Specialist',       'bio' => 'Manages 7-figure ad budgets with a performance-first mindset.',              'email' => 'rizky@storytale.id', 'instagram' => '@rizkymaulana', 'linkedin' => 'linkedin.com/in/rizkymaulana', 'sort_order' => 3]);
        $nadia = TeamMember::create(['name' => 'Nadia Kusuma',  'role' => 'Social Media Manager',        'bio' => 'Grows communities that convert, not just scroll.',                            'email' => 'nadia@storytale.id', 'instagram' => '@nadiakusuma',  'linkedin' => 'linkedin.com/in/nadiakusuma',  'sort_order' => 4]);

        // Categories
        $da  = ProjectCategory::create(['name' => 'Digital Ads',      'slug' => 'digital-ads']);
        $rm  = ProjectCategory::create(['name' => 'Rich Media',        'slug' => 'rich-media']);
        $nl  = ProjectCategory::create(['name' => 'Newsletter',        'slug' => 'newsletter']);
        $ds  = ProjectCategory::create(['name' => 'Digital Strategy',  'slug' => 'digital-strategy']);
        $va  = ProjectCategory::create(['name' => 'Video Ads',         'slug' => 'video-ads']);
        $web = ProjectCategory::create(['name' => 'Website',           'slug' => 'website']);
        $crm = ProjectCategory::create(['name' => 'CRM',               'slug' => 'crm']);
        $ai  = ProjectCategory::create(['name' => 'AI Apps',           'slug' => 'ai-apps']);

        // Projects
        Project::create(['category_id' => $da->id,  'title' => 'Kopi Nusantara — Search & Display Ads',    'slug' => 'kopi-nusantara-digital-ads',  'client' => 'Kopi Nusantara',  'description' => 'Launched multi-channel search and display campaigns achieving 4.2× ROAS and 38% reduction in cost-per-lead within 3 months.',            'project_year' => 2024, 'is_featured' => true,  'sort_order' => 1]);
        Project::create(['category_id' => $rm->id,  'title' => 'BeautyLab — HTML5 Rich Media Banners',     'slug' => 'beautylab-rich-media',        'client' => 'BeautyLab',       'description' => 'Designed and developed an interactive HTML5 ad suite delivering 380% higher engagement vs. standard static banners.',                       'project_year' => 2024, 'is_featured' => true,  'sort_order' => 2]);
        Project::create(['category_id' => $nl->id,  'title' => 'Lawson ID — Email Newsletter Campaign',    'slug' => 'lawson-id-newsletter',        'client' => 'Lawson Indonesia', 'description' => 'Built an automated newsletter system achieving a 42% open rate and 8× ROI across 6 monthly campaigns.',                                      'project_year' => 2023, 'is_featured' => false, 'sort_order' => 3]);
        Project::create(['category_id' => $ds->id,  'title' => 'EduPath — Annual Digital Strategy',        'slug' => 'edupath-digital-strategy',    'client' => 'EduPath',         'description' => 'Full-year digital strategy roadmap across 5 channels resulting in 310% growth in qualified inbound leads.',                                  'project_year' => 2024, 'is_featured' => true,  'sort_order' => 4]);
        Project::create(['category_id' => $va->id,  'title' => 'Toko Sehat — TikTok & YouTube Video Ads',  'slug' => 'toko-sehat-video-ads',        'client' => 'Toko Sehat',      'description' => 'Produced 24 short-form video ads for TikTok and YouTube pre-roll, driving 2M+ views and 180% lift in conversion rate.',                   'project_year' => 2024, 'is_featured' => true,  'sort_order' => 5]);
        Project::create(['category_id' => $web->id, 'title' => 'Pondok Asri — Website Redesign',           'slug' => 'pondok-asri-website',         'client' => 'Pondok Asri',     'description' => 'End-to-end website redesign achieving 270% more organic traffic, 45% lower bounce rate, and a 3.8× conversion uplift.',                  'project_year' => 2023, 'is_featured' => true,  'sort_order' => 6]);
        Project::create(['category_id' => $crm->id, 'title' => 'Matahari — CRM Setup & Automation',        'slug' => 'matahari-crm',                'client' => 'Matahari',        'description' => 'Migrated legacy data and built automated CRM workflows, cutting lead response time by 52% and increasing pipeline value by 190%.',         'project_year' => 2024, 'is_featured' => false, 'sort_order' => 7]);
        Project::create(['category_id' => $ai->id,  'title' => 'GreenSpace — AI Customer Chatbot',         'slug' => 'greenspace-ai-chatbot',       'client' => 'GreenSpace ID',   'description' => 'Built a custom LLM-powered chatbot handling 70% of customer queries autonomously, available 24/7 with sub-1-second response time.',       'project_year' => 2025, 'is_featured' => true,  'sort_order' => 8]);
        Project::create(['category_id' => $da->id,  'title' => 'Wahana Kuliner — Meta & Google Ads',       'slug' => 'wahana-kuliner-digital-ads',  'client' => 'Wahana Kuliner',  'description' => 'Scaled a Rp 80jt/month Meta and Google Ads budget to deliver 5.1× ROAS for a multi-location F&B chain.',                                  'project_year' => 2024, 'is_featured' => false, 'sort_order' => 9]);

        // Blog tags
        $tags = collect(['Social Media','Content','Paid Ads','SEO','Strategy','Branding','TikTok','Instagram'])
            ->mapWithKeys(fn($name) => [
                $name => BlogTag::create(['name' => $name, 'slug' => str()->slug($name)])
            ]);

        // Blog posts
        $p1 = BlogPost::create(['author_id' => $sari->id,  'title' => '5 Content Frameworks That Drive Engagement in 2025',          'slug' => '5-content-frameworks-2025',      'excerpt' => 'Most brands create content. Few create content that converts. Here are the 5 frameworks our team uses to build stories that drive real action.',       'status' => 'published', 'published_at' => '2025-03-10 09:00:00']);
        $p2 = BlogPost::create(['author_id' => $rizky->id, 'title' => 'Why Your Meta Ads Are Bleeding Money (And How to Fix It)',     'slug' => 'why-meta-ads-bleeding-money',     'excerpt' => 'A high CTR with a low ROAS means your funnel is broken, not your ads. Here is exactly where the leak is and how to patch it.',                          'status' => 'published', 'published_at' => '2025-02-20 09:00:00']);
        $p3 = BlogPost::create(['author_id' => $andi->id,  'title' => 'From 0 to 100K Followers: The STORYTALE Method',              'slug' => 'storytale-method-0-to-100k',     'excerpt' => 'We have grown 12 brand accounts past 100K followers. This is the repeatable system behind every single one of them.',                                   'status' => 'published', 'published_at' => '2025-01-15 09:00:00']);
        $p4 = BlogPost::create(['author_id' => $nadia->id, 'title' => 'The Instagram Algorithm in 2025: What Actually Works',        'slug' => 'instagram-algorithm-2025',        'excerpt' => 'Forget the hacks. Here is what the data from 30 managed accounts tells us about what the algorithm rewards right now.',                                   'status' => 'published', 'published_at' => '2025-04-05 09:00:00']);

        $p1->tags()->attach([$tags['Social Media']->id, $tags['Content']->id, $tags['Strategy']->id]);
        $p2->tags()->attach([$tags['Paid Ads']->id, $tags['Strategy']->id]);
        $p3->tags()->attach([$tags['Social Media']->id, $tags['Instagram']->id, $tags['Strategy']->id]);
        $p4->tags()->attach([$tags['Social Media']->id, $tags['Instagram']->id]);

        // Sample contact submission
        ContactSubmission::create(['name' => 'Budi Santoso', 'email' => 'budi@contoh.com', 'phone' => '+62811000001', 'company' => 'Contoh Brand', 'service' => 'social_media', 'message' => 'Kami tertarik dengan layanan social media management untuk brand kami.', 'ip_address' => '127.0.0.1']);

        // Journals
        Journal::create(['title' => 'How We Scaled Kopi Nusantara to 120K in 6 Months', 'slug' => 'kopi-nusantara-case-study', 'category' => 'case-study', 'excerpt' => 'A deep-dive into the content system, community strategy, and creative framework that took a local coffee brand from 8K to 120K followers.', 'status' => 'published', 'published_at' => '2025-03-01', 'sort_order' => 1]);
        Journal::create(['title' => 'The Anatomy of a High-Converting Meta Ad', 'slug' => 'meta-ads-anatomy', 'category' => 'learning', 'excerpt' => 'We broke down 200 of our best-performing Meta ads to find the patterns. Here is what separates a 4× ROAS campaign from a money pit.', 'status' => 'published', 'published_at' => '2025-04-10', 'sort_order' => 2]);
        Journal::create(['title' => '2025 Digital Marketing Trends in Southeast Asia', 'slug' => 'digital-trends-sea-2025', 'category' => 'insight', 'excerpt' => 'AI-generated content, short-form video dominance, and the rise of micro-influencers — what brands in SEA need to prepare for.', 'status' => 'published', 'published_at' => '2025-01-20', 'sort_order' => 3]);
        Journal::create(['title' => 'Building a Website That Converts: A STORYTALE Framework', 'slug' => 'website-conversion-framework', 'category' => 'learning', 'excerpt' => 'Most agency websites are brochures. Ours convert. Here is the exact framework we use for every client website build.', 'status' => 'published', 'published_at' => '2025-05-05', 'sort_order' => 4]);
        Journal::create(['title' => 'CRM for SMEs: Why Most Implementations Fail', 'slug' => 'crm-sme-implementation', 'category' => 'insight', 'excerpt' => 'After implementing CRM for 15 SMEs, we identified the 5 mistakes that kill adoption before the system even goes live.', 'status' => 'published', 'published_at' => '2025-02-14', 'sort_order' => 5]);
        Journal::create(['title' => 'STORYTALE Agency Profile 2026', 'slug' => 'agency-profile-2026', 'category' => 'whitepaper', 'excerpt' => 'Our full credentials deck — services, case studies, team, and approach for potential partners and clients.', 'status' => 'published', 'published_at' => '2026-01-01', 'sort_order' => 6]);

        // Services
        $servicesData = [
            ['name'=>'Digital Ads',      'slug'=>'digital-ads',      'color'=>'#FF2D2D', 'description'=>'Performance campaigns across Search, Display, Social, and Programmatic — built for ROAS, not vanity.', 'scope_items'=>['Search & Display Ads','Meta & TikTok Ads','Programmatic Buying','Remarketing & Funnels'], 'sort_order'=>1],
            ['name'=>'Rich Media',       'slug'=>'rich-media',       'color'=>'#FF6B00', 'description'=>'Immersive HTML5 ad experiences that stop the scroll and outperform static banners every time.', 'scope_items'=>['Interactive HTML5 Banners','Dynamic Creative Units','Expandable & Video Ads','Landing Page Design'], 'sort_order'=>2],
            ['name'=>'Newsletter',       'slug'=>'newsletter',       'color'=>'#9900DD', 'description'=>'Nurture leads into loyal buyers with campaigns that feel personal, timely, and on-brand.', 'scope_items'=>['Campaign Design & Copy','Automation Flows','List Segmentation','A/B Testing & Reporting'], 'sort_order'=>3],
            ['name'=>'Digital Strategy', 'slug'=>'digital-strategy', 'color'=>'#2255FF', 'description'=>'Data-driven roadmaps that connect audience insights, channels, and KPIs into one coherent growth plan.', 'scope_items'=>['Market & Audience Research','Channel Planning','12-Month Content Calendar','KPI Framework & Reviews'], 'sort_order'=>4],
            ['name'=>'Video Ads',        'slug'=>'video-ads',        'color'=>'#E91E8C', 'description'=>'Story-driven video productions engineered for the platforms that matter — TikTok, Reels, and YouTube.', 'scope_items'=>['TikTok & Reels Scripts','YouTube Pre-roll','Motion Graphics','Full Video Production'], 'sort_order'=>5],
            ['name'=>'Website',          'slug'=>'website',          'color'=>'#00AA50', 'description'=>'High-converting web experiences designed from business goals up — beautiful, fast, and built to grow.', 'scope_items'=>['UI/UX Design','Web Development','CRO Strategy','SEO & Performance'], 'sort_order'=>6],
            ['name'=>'CRM',              'slug'=>'crm',              'color'=>'#0088CC', 'description'=>'Connect your data, automate your pipeline, and turn every customer touchpoint into a revenue opportunity.', 'scope_items'=>['CRM Setup & Migration','Workflow Automation','Customer Segmentation','Reporting Dashboard'], 'sort_order'=>7],
            ['name'=>'AI Apps',          'slug'=>'ai-apps',          'color'=>'#FFE500', 'description'=>'Custom AI-powered tools that automate work, personalise experiences, and give your business an unfair edge.', 'scope_items'=>['AI Chatbots & Assistants','LLM Integrations','Automation Scripts','Custom Data Pipelines'], 'sort_order'=>8],
        ];
        foreach ($servicesData as $s) Service::create($s);
    }
}
