<?php

namespace App\Http\Controllers;

use App\Models\AuthorizationSource;
use Illuminate\Http\Request;

class AuthorizationSourceController extends Controller
{
    public function index()
    {
        return AuthorizationSource::all();
    }

    public function store(Request $request)
    {
        return response(
            AuthorizationSource::create($request->all()),
            201
        );
    }

    public function show(AuthorizationSource $authorization_source)
    {
        return $authorization_source;
    }

    public function update(Request $request, AuthorizationSource $authorization_source)
    {
        $authorization_source->update($request->all());

        return $authorization_source->refresh();
    }

    public function destroy(AuthorizationSource $authorization_source)
    {
        return response(
            $authorization_source->delete(),
            204
        );
    }
}
