<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('delfood-1.0.0.index');
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('delfood-1.0.0.about');
    }

    /**
     * Show the blog page.
     *
     * @return \Illuminate\View\View
     */
    public function blog()
    {
        return view('delfood-1.0.0.blog');
    }

    /**
     * Show the testimonials page.
     *
     * @return \Illuminate\View\View
     */
    public function testimonials()
    {
        return view('delfood-1.0.0.testimonial');
    }
}
