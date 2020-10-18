<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class TreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dir_tree')->insert([
            'user_id' => 1,
            'tree' => '{"id":0,"isLeaf":false,"name":"root","children":[{"id":1,"isLeaf":false,"name":"Folder 1","pid":0,"children":[{"id":2,"isLeaf":true,"name":"File1.txt","pid":1},{"id":3,"isLeaf":true,"name":"Email.php","pid":1}]},{"id":4,"isLeaf":false,"name":"Folder 2","pid":0,"children":[{"id":6,"isLeaf":false,"name":"Folder 2.1","pid":4},{"id":7,"isLeaf":true,"name":"Send.java","pid":4}]},{"id":5,"isLeaf":false,"name":"Folder 3","pid":0,"children":[{"id":8,"isLeaf":false,"name":"Folder 4","pid":5}]}]}'
        ]);
    }
}
