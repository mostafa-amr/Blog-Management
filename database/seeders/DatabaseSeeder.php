<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
       app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

       //permissions and roles
       $permissions = [
        'export_blog_posts',
        'import_blog_posts',
        'view_blog_posts',
        'create_blog_posts',
        'edit_blog_posts',
        'delete_blog_posts',
        'view_users',
        'create_users',
        'edit_users',
        'delete_users'
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

       $adminRole  = Role::firstOrCreate(['name' => 'admin']);
       $authorRole = Role::firstOrCreate(['name' => 'author']);

       $adminRole->givePermissionTo(['export_blog_posts','import_blog_posts','view_blog_posts','create_blog_posts','edit_blog_posts','delete_blog_posts','view_users','create_users','edit_users','delete_users']);
       $authorRole->givePermissionTo(['export_blog_posts','view_blog_posts','create_blog_posts','edit_blog_posts','delete_blog_posts']);

       //admin user
       $admin = User::factory()->create([
           'name'     => 'Admin',
           'email'    => 'admin@blog.com',
           'password' => bcrypt('password'),
       ]);
       $admin->assignRole($adminRole);

       // author user
       $author = User::factory()->create([
           'name'     => 'Author',
           'email'    => 'author@blog.com',
           'password' => bcrypt('password'),
       ]);
       $author->assignRole($authorRole);

       // blog posts for the admin 
       BlogPost::factory()->count(5)->create([
           'user_id' => $admin->id,
       ]);

       // blog posts for the author
       BlogPost::factory()->count(5)->create([
           'user_id' => $author->id,
       ]);
    }
}
