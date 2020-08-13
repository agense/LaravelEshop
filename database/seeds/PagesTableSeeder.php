<?php

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/pages.json"; 
        $data = json_decode(file_get_contents($path), true); 

        foreach($data as $page){
            Page::create([
                'title' => $page['title'],
                'type' => $page['type'],
                'content' => $page['content']
            ]);
        }
    }
}
