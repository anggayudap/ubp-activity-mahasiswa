<?php

namespace App\Http\Controllers\API;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KegiatanResource;

class KegiatanController extends Controller
{
    public function index()
    {
        //get posts
        $posts = Kegiatan::latest()->paginate(5);

        //return collection of posts as a resource
        return new KegiatanResource('200', 'List Data Kegiatan', $posts);
    }
}
