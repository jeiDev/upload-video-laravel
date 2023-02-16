<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('videos')->insert([
            'title' => 'Video tutorial',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore molestiae est eos a',
            'video_name' => 'video-1.mp4'
        ]);

        DB::table('videos')->insert([
            'title' => 'Video tutorial 2',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore molestiae est eos a',
            'video_name' => 'video-1.mp4'
        ]);

        DB::table('videos')->insert([
            'title' => 'Video tutorial 3',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore molestiae est eos a',
            'video_name' => 'video-1.mp4'
        ]);
    }
}
