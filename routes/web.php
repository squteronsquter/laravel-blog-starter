<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('posts');
});

Route::get('posts/{post}', function ($slug) {

    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    if(! file_exists($path)) {

        return redirect('/');

    }

    $post = cache() -> remember('posts.{$slug}', now() -> addMinutes(60), function () use ($path) {

	    var_dump('Not cashed version');
	
	    return file_get_contents($path);
	
    });
    
    
    $post = file_get_contents($path);
    
    return view('post', [   
        'post' => $post
    ]);
})->where('post', '[A-z_\-]+');

