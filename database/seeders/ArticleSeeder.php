<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Why South Africa Needs a Smoke-Free Generation by 2030',
                'excerpt' => 'Tobacco use still starts young. Here is why SATFYF is betting on youth voices, not warning labels, to change that.',
                'body' => "Tobacco companies have long targeted young people with flavoured products, sleek packaging and social media influence.\n\nSATFYF exists because policy alone hasn't been enough. Youth voices — in schools, on social media, at community imbizos — reach young people where warning labels can't.\n\nOur Vision 2030 is simple: young people who reject smoking in social settings, campuses that are genuinely smoke-free, and a generation confident enough to say no.",
                'author_name' => 'SATFYF Communications',
            ],
            [
                'title' => 'Inside a SATFYF Think Session: What Young People Actually Ask',
                'excerpt' => 'We sat in on a Think Session in Centurion. The questions from learners were sharper than we expected.',
                'body' => "Think Sessions are SATFYF's core education format — small, structured conversations rather than lectures.\n\nThe questions ranged from vaping regulation to why cigarette marketing still reaches teenagers online. Facilitators don't lecture; they let the room reach its own conclusions with the facts in front of them.\n\nThat's the model: give young people real information, then trust them to lead.",
                'author_name' => 'SATFYF Communications',
            ],
            [
                'title' => 'Vaping Isn\'t "Safer": What the Research Actually Says',
                'excerpt' => 'Nicotine is nicotine. A plain-language look at the evidence behind vaping and youth nicotine addiction.',
                'body' => "Vaping is often marketed to young people as a harmless alternative to smoking. The evidence tells a more complicated story.\n\nNicotine, regardless of delivery method, is highly addictive — and adolescent brains are especially vulnerable to that addiction taking hold.\n\nSATFYF's Research & Policy team breaks down what's actually known, and what's still marketing.",
                'author_name' => 'Sipho Nkosi',
            ],
            [
                'title' => 'Community Imbizos: Why We Still Gather the Old Way',
                'excerpt' => 'In a digital campaign era, SATFYF still runs traditional community imbizos. Here\'s why that matters.',
                'body' => "A Community Imbizo brings parents, teachers, youth and local leaders into the same room — a format rooted in South African tradition, not imported campaign playbooks.\n\nIt works because tobacco-free choices are made in families and communities, not in isolation. Imbizos let SATFYF listen as much as it speaks.",
                'author_name' => 'Amahle Zulu',
            ],
            [
                'title' => 'Reading the New Tobacco Products Bill: What Youth Need to Know',
                'excerpt' => 'South Africa\'s tobacco control legislation is evolving. Here\'s a plain-language explainer for young people.',
                'body' => "Proposed tobacco control legislation touches everything from public smoking areas to packaging and vaping products.\n\nSATFYF's policy brief breaks down what's actually being proposed, who it affects, and how young people can make their voices heard in the public comment process.",
                'author_name' => 'Sipho Nkosi',
            ],
            [
                'title' => 'From Bystander to Advocate: One Volunteer\'s Story',
                'excerpt' => 'A SATFYF youth ambassador on what changed after her first public demonstration.',
                'body' => "\"I used to think advocacy was for other people — louder people,\" says one SATFYF youth ambassador.\n\nHer first public demonstration changed that. What started as one Saturday morning turned into leading Think Sessions at her own school a year later.\n\nThis is what SATFYF means by youth-led: not youth as an audience, but youth as the ones holding the microphone.",
                'author_name' => 'SATFYF Communications',
            ],
        ];

        foreach ($articles as $index => $article) {
            Article::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    ...$article,
                    'slug' => Str::slug($article['title']),
                    'cover_image_path' => null,
                    'published_at' => now()->subWeeks($index * 2 + 1),
                ],
            );
        }

        Article::factory(4)->create();
    }
}
