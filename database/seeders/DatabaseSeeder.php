<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Иван Иванов',
                'password' => Hash::make('password123'),
            ]
        );

        $catPhp = Category::firstOrCreate(['slug' => 'php'], ['name' => 'PHP и Laravel']);
        $catWeb = Category::firstOrCreate(['slug' => 'web'], ['name' => 'Веб-разработка']);
        $catDb = Category::firstOrCreate(['slug' => 'databases'], ['name' => 'Базы данных']);

        $tagBackend = Tag::firstOrCreate(['slug' => 'backend'], ['name' => 'Backend']);
        $tagTutorial = Tag::firstOrCreate(['slug' => 'tutorial'], ['name' => 'Туториал']);
        $tagEloquent = Tag::firstOrCreate(['slug' => 'eloquent'], ['name' => 'Eloquent ORM']);

        $post1 = Post::firstOrCreate(
            ['title' => 'Погружение в Eloquent ORM'],
            [
                'user_id' => $user->id,
                'category_id' => $catPhp->id,
                'content' => 'Eloquent делает работу со связями в базе данных максимально приятной и выразительной.',
                'is_published' => true,
                'views_count' => 150,
            ]
        );
        $post1->tags()->sync([$tagBackend->id, $tagEloquent->id]);

        $post2 = Post::firstOrCreate(
            ['title' => 'Советы по ускорению SQL запросов'],
            [
                'user_id' => $user->id,
                'category_id' => $catDb->id,
                'content' => 'Индексы, денормализация и правильные джойны ускоряют работу в десятки раз.',
                'is_published' => true,
                'views_count' => 45,
            ]
        );
        $post2->tags()->sync([$tagBackend->id]);

        $post3 = Post::firstOrCreate(
            ['title' => 'Черновик будущей статьи по Docker'],
            [
                'user_id' => $user->id,
                'category_id' => $catWeb->id,
                'content' => 'Этот пост ещё находится в разработке и не опубликован.',
                'is_published' => false,
                'views_count' => 0,
            ]
        );
        $post3->tags()->sync([$tagTutorial->id]);

        Comment::firstOrCreate(
            [
                'commentable_id' => $post1->id,
                'commentable_type' => Post::class,
                'body' => 'Отличная статья, всё понятно!',
            ],
            [
                'user_id' => $user->id,
            ]
        );

        Comment::firstOrCreate(
            [
                'commentable_id' => $post1->id,
                'commentable_type' => Post::class,
                'body' => 'Интересный материал.',
            ],
            [
                'user_id' => $user->id,
            ]
        );
    }
}
