<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Location;
use App\LocationAdditions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        return view('locations.index', [
            'locations' => Auth::user()->locations,
        ]);
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(CreateLocationRequest $request)
    {
        if ($request->type != 'general') {
            Auth::user()->locations()->whereType($request->type)->update(['type' => 'general']);
        }

        if ($request->type == "business") {
            $validator = $this->_getRequestValidator($request);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator);
            }
        }

        $data = $request->only(['name', 'description', 'person', 'email', 'phone', 'street', 'city', 'type']);
        $data['additionals'] = json_encode($request->only(LocationAdditions::allFieldKeys()));

        Auth::user()->locations()->create($data);

        $request->session()->flash('status', 'Der Lernort wurde erfolgreich erstellt.');

        return redirect()->route('locations.index');
    }

    public function show(Location $location)
    {
        $this->authorize('view', $location);

        return view('locations.show', [
            'location' => $location,
        ]);
    }

    public function edit(Location $location)
    {
        $this->authorize('view', $location);

        return view('locations.edit', [
            'location' => $location,
        ]);
    }

    public function update(CreateLocationRequest $request, Location $location)
    {
        $this->authorize('update', $location);

        if ($request->type != 'general') {
            Auth::user()->locations()->whereType($request->type)->where('id', '!=', $location->id)->update(['type' => 'general']);
        }

        if ($request->type == "business") {
            $validator = $this->_getRequestValidator($request);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator);
            }
        }

        $data = $request->only(['name', 'description', 'person', 'email', 'phone', 'street', 'city', 'type']);
        $data['additionals'] = json_encode($request->only(LocationAdditions::allFieldKeys()));

        $location->update($data);

        $request->session()->flash('status', 'Der Lernort wurde erfolgreich gespeichert.');

        return redirect()->route('locations.index');
    }

    public function destroy(Request $request, Location $location)
    {
        $this->authorize('delete', $location);

        $location->delete();

        $request->session()->flash('status', 'Der Lernort wurde erfolgreich gelöscht.');

        return redirect()->route('locations.index');
    }

    protected function _getRequestValidator(CreateLocationRequest $request) {
        $fields = ['name', 'description', 'person', 'email', 'phone', 'street', 'city', 'type'];

        $additionalFields = LocationAdditions::getFields($request->type);
        if(!empty($additionalFields)) {
            $fields = array_merge($fields, array_keys($additionalFields));
        }

        $validatorData = array_combine($fields, array_fill(0, count($fields), 'required'));

        return Validator::make($request->only($fields), $validatorData);
    }

}
