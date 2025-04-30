<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Course;
use App\Models\PrivateSession;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;




class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // حماية: تنفيذ الكود فقط إذا كانت جداول قاعدة البيانات موجودة
        if (Schema::hasTable('courses')) {
            View::composer('*', function ($view) {
                if (auth()->check() && auth()->user()->role == 'instructor') {
                    $courses = \App\Models\Course::where('instructor_id', auth()->id())->get();
                    $view->with('instructorCourses', $courses);
                }
            });
        }
    
        Relation::morphMap([
            'Course' => Course::class,
            'PrivateSession' => PrivateSession::class,
        ]);
        
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'course' => \App\Models\Course::class,
            'private_session' => \App\Models\PrivateSession::class,
            'App\Models\Course' => \App\Models\Course::class,
            'App\Models\PrivateSession' => \App\Models\PrivateSession::class,
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   
}
