<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deployment;
use App\Http\Requests\StoreDeploymentRequest;
use App\Http\Requests\UpdateDeploymentRequest;
use App\Models\District;

class DeploymentController extends Controller
{
    public function index()
    {
        $deployments = Deployment::latest()->paginate(10);
        return view('admin.deployments.index', compact('deployments'));
    }

   public function create()
{
    $districts = District::all();
    $manpowers = \App\Models\Manpower::all();
    $reliefMaterials = \App\Models\ReliefMaterial::all();

    return view('admin.deployments.create', compact('districts', 'manpowers', 'reliefMaterials'));
}

public function edit(Deployment $deployment)
{
    $districts = District::all();
    $manpowers = \App\Models\Manpower::all();
    $reliefMaterials = \App\Models\ReliefMaterial::all();

    return view('admin.deployments.edit', compact('deployment', 'districts', 'manpowers', 'reliefMaterials'));
}


    public function store(StoreDeploymentRequest $request)
    {
        Deployment::create($request->validated());
        return redirect()->route('admin.deployments.index')->with('success', 'Deployment created successfully.');
    }

    
    public function update(UpdateDeploymentRequest $request, Deployment $deployment)
    {
        $deployment->update($request->validated());
        return redirect()->route('admin.deployments.index')->with('success', 'Deployment updated successfully.');
    }

    public function destroy(Deployment $deployment)
    {
        $deployment->delete();
        return redirect()->route('admin.deployments.index')->with('success', 'Deployment deleted successfully.');
    }
}
