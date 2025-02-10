<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicBlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = 'a';
        $tags = 'a';

        $dataMedicine = [
            'message' => '',
            'med' => ''
        ];

        $medicineRequest = getMedicinesData();
        if (isset($medicineRequest['error'])) {
            $dataMedicine['message'] = $medicineRequest['error'];
            $dataMedicine['med'] = null;
        } else {
            $dataMedicine['message'] = 'OK';
            $dataMedicine['med'] = $medicineRequest;
        }

        foreach ($dataMedicine['med']['medicines'] as &$med) {
            $response = getMedicineDetail($med['id']);
            $validPrice = null;
            $currentDate = Carbon::now()->toDateString();

            foreach ($response['prices'] as $price) {
                $startDate = Carbon::parse($price['start_date']['value'])->toDateString();
                $endDate = Carbon::parse($price['end_date']['value'])->toDateString();

                if ($currentDate >= $startDate && $currentDate <= $endDate) {
                    $validPrice = $price['unit_price'];
                    break;
                }
            }

            $med['valid_price'] = $validPrice;
        }

        // dd($dataMedicine);

        return view('public-blog.blog.blog-new', compact('posts', 'tags', 'dataMedicine'));
    }



    public function show($slug)
    {
        $tags = 'xxx';
        $post = 'ax';

        return view('public-blog.blog.detail', compact('post', 'tags'));
    }
}
