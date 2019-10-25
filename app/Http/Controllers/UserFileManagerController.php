<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\UserFileManager;
use App\Models\AdminFileManager;
use Spatie\MediaLibrary\MediaStream;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as ValidateRequest;

class UserFileManagerController extends Controller
{
    public function create()
    {

        return Inertia::render('ContractManager/User/Create', [
            'url' => url('/'),
            'files' => AdminFileManager::orderByTitle()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value' => $field->id,
                        'name'  => $field->title
                    ];
                }),
            'users' => User::orderByName()
                ->get()
                ->transform(function ($field) {
                    return [
                        'value' => $field->id,
                        'name'  => $field->name
                    ];
                })
        ]);
    }

    public function delete(Request $request)
    {
        $user_file_manager = UserFileManager::findorfail($request->id);
        $user_file_manager->delete();
        return Redirect::route('user_file_manager')->with('success', 'User File Manager ' . $user_file_manager->title . ' was successfully delete.');
    }

    public function download_files(AdminFileManager $admin_file_manager)
    {
        $admin = AdminFileManager::findOrFail($admin_file_manager->id);
        $media  = $admin->getMedia('admin_file_managers');
        return MediaStream::create($admin->title . '.zip')->addMedia($media);
    }

    public function edit(UserFileManager $user_file_manager)
    {
        $media  = $user_file_manager->getMedia('user_file_managers');
        $images = [];

        foreach ($media as $item) {
            array_push($images, $item->getFullUrl());
        }

        return Inertia::render(
            'ContractManager/User/Edit',
            [
                'url' => url('/'),
                'documents' => $images,
                'files'     => [
                    'id'             => $user_file_manager->id,
                    'file_id'          => $user_file_manager->file_id,
                    'member_id'      => $user_file_manager->member_id,
                    'date_submitted' => $user_file_manager->date_submitted
                ],
                'files_data' => AdminFileManager::orderByTitle()
                    ->get()
                    ->transform(function ($field) {
                        return [
                            'value' => $field->id,
                            'name'  => $field->title
                        ];
                    }),
                'users'     => User::orderByName()
                    ->get()
                    ->transform(function ($field) {
                        return [
                            'value' => $field->id,
                            'name'  => $field->name
                        ];
                    })
            ]
        );
    }

    public function view(UserFileManager $user_file_manager)
    {
        $media  = $user_file_manager->getMedia('user_file_managers');
        $images = [];

        foreach ($media as $item) {
            array_push($images, $item->getFullUrl());
        }

        return Inertia::render(
            'ContractManager/User/View',
            [
                'url' => url('/'),
                'documents' => $images,
                'files'     => [
                    'id'             => $user_file_manager->id,
                    'file_id'          => $user_file_manager->file_id,
                    'member_id'      => $user_file_manager->member_id,
                    'date_submitted' => $user_file_manager->date_submitted,
                    'date_approved' => $user_file_manager->date_approved
                ],
                'files_data' => AdminFileManager::orderByTitle()
                    ->get()
                    ->transform(function ($field) {
                        return [
                            'value' => $field->id,
                            'name'  => $field->title
                        ];
                    }),
                'users'     => User::orderByName()
                    ->get()
                    ->transform(function ($field) {
                        return [
                            'value' => $field->id,
                            'name'  => $field->name
                        ];
                    })
            ]
        );
    }


    public function index()
    {
        return Inertia::render('ContractManager/User/Index', [
            'files' => UserFileManager::with('member','file')
                ->get()
                ->transform(function ($field) {
                    return [
                        'id'             => $field->id,
                        'member'         => $field->member->name,
                        'title'          => $field->file->title,
                        'date_submitted' => $field->date_submitted,
                        'approved'       => $field->approved,
                        'date_approved'  => $field->date_approved
                    ];
                })
        ]);
    }

    public function store()
    {
        $user_file_manager = UserFileManager::create(
            ValidateRequest::validate([
                'member_id'      => ['required', 'exists:users,id'],
                'file_id'      => ['required', 'exists:admin_file_managers,id'],
                'date_submitted' => ['required', 'date']
            ])
        );

        $user_file_manager->clearMediaCollection('user_file_managers');
        $user_file_manager->addAllMediaFromRequest()
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('user_file_managers');
            });

        return Redirect::route('user_file_manager')->with('success', 'User File Manager ' . $user_file_manager->title . ' was successfully created.');
    }

    public function update()
    {
        ValidateRequest::validate([
            'member_id'      => ['required', 'exists:users,id'],
            'file_id'      => ['required', 'exists:admin_file_managers,id'],
            'date_submitted' => ['required', 'date']
        ]);
        $data = ValidateRequest::all();

        $pay                 = UserFileManager::findorfail($data['id']);
        $pay->member_id      = $data['member_id'];
        $pay->file_id      = $data['file_id'];
        $pay->date_submitted = $data['date_submitted'];
        $pay->save();

        if ($data['images']) {
            $pay->clearMediaCollection('user_file_managers');
            $pay->addAllMediaFromRequest()
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('user_file_managers');
                });
        }

        return Redirect::route('user_file_manager.edit', $pay)->with('success', 'User File Manager was successfully updated.');
    }

    public function view_downloadable_files()
    {
        return Inertia::render('ContractManager/User/Download', [
            'files' => AdminFileManager::whereActive(true)
                ->get()
                ->transform(function ($field) {
                    return [
                        'id'    => $field->id,
                        'title' => $field->title,
                        'count' => $field->getMedia('admin_file_managers')->count()
                    ];
                })
        ]);
    }
}
