<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\AdminFileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as ValidateRequest;

class AdminFileManagerController extends Controller
{
    public function index()
    {
        return Inertia::render('ContractManager/Admin/Index', [

            'files' => AdminFileManager::all()
                ->transform(function ($field) {
                    return [
                        'id' => $field->id,
                        'title' => $field->title,
                        'active' => $field->active,

                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('ContractManager/Admin/Create', [
            'url' => url('/'),
        ]);
    }

    public function store()
    {
        $admin_file_manager = AdminFileManager::create(
            ValidateRequest::validate([
                'title' => ['required', 'max:50'],
                'active' => [],
            ])
        );

        $admin_file_manager->clearMediaCollection('admin_file_managers');
        $admin_file_manager->addAllMediaFromRequest()
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('admin_file_managers');
            });

        return Redirect::route('admin_file_manager')->with('success', 'Admin File Manager ' .  $admin_file_manager->title . ' was successfully created.');
    }

    public function delete(Request $request)
    {
        $admin_file_manager = AdminFileManager::findorfail($request->id);
        $admin_file_manager->delete();
        return Redirect::route('admin_file_manager')->with('success', 'Admin File Manager '  .  $admin_file_manager->title . ' was successfully delete.');
    }

    public function edit(AdminFileManager $admin_file_manager)
    {

        $media  = $admin_file_manager->getMedia('admin_file_managers');
        $images = [];
        foreach ($media as $item) {
            array_push($images, $item->getFullUrl());
        }

        return Inertia::render('ContractManager/Admin/Edit', [
            'url' => url('/'),
            'documents' => $images,
            'files' => [
                'id' => $admin_file_manager->id,
                'title' => $admin_file_manager->title,
                'active' => $admin_file_manager->active
            ]
        ]);
    }

    public function update()
    {
        ValidateRequest::validate([
            'title' => ['required'],
            'active' => [],
        ]);
        $data = ValidateRequest::all();

        $pay = AdminFileManager::findorfail($data['id']);
        $pay->title = $data['title'];
        $pay->active = $data['active'];
        $pay->save();

        if ($data['images']) {
            $pay->clearMediaCollection('admin_file_managers');
            $pay->addAllMediaFromRequest()
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('admin_file_managers');
                });
        }

        return Redirect::route('admin_file_manager.edit', $pay)->with('success', 'Admin File Manager was successfully updated.');
    }
}
