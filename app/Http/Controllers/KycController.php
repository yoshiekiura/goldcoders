<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\ZipStreamResponse;

class KycController extends Controller
{
    public function downloads()
    {
        //get all files in the download collection
        $allMedia = Auth::user()->getMedia('kyc');

        // download them in a streamed way, so no prob if your files are very large
        return ZipStreamResponse::create('kyc.zip')->addMedia($allMedia);
    }

    public function show()
    {
        $user   = Auth::user();
        $media  = $user->getMedia('kyc');
        $images = [];

        foreach ($media as $item) {
            # code...
            array_push($images, $item->getFullUrl());
        }

        return Inertia::render('Wizard/Kyc', ['account' => $user, 'kyc' => $images]);
    }

    /**
     * @param Request $request1
     */
    public function uploads(Request $request)
    {
        // make sure to remove remember query string middleware it cause error
        $user = $request->user();
        $user->clearMediaCollection('kyc');
        $user->addAllMediaFromRequest()
             ->each(function ($fileAdder) {
                 $fileAdder->toMediaCollection('kyc');
             });

        return Redirect::route('kyc.show')->with('success', 'ID Successfully Uploaded!');
    }
}
