<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Resources\Api\UserRequestResource;
use App\Models\UserRequestForm;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserRequestFormController extends Controller {
    
    public function index(): AnonymousResourceCollection{
        $requests = UserRequestForm::with('form.fields')->latest()->get(); 
        return UserRequestResource::collection($requests);
    }

    public function show(UserRequestForm $user_request): UserRequestResource{
        $user_request->load('form');
        return UserRequestResource::make($user_request);
    }

    public function store(StoreUserRequest $request): UserRequestResource {
        $data = $request->validated();

        $request = UserRequestForm::create([
            'form_id' => $data['form_id'],
            'request_name' => $data['form_id'],
            'form_data' => $data['form_data'], // On sauvegarde le reste des données en tant que JSON
        ]);

        return UserRequestResource::make($request);
    }

}
