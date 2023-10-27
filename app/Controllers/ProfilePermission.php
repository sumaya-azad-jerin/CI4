<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProfileModel;

class ProfilePermission extends Controller
{
    public function index()
    {
        // Load the ProfileModel
        $profileModel = new ProfileModel();

        // Get all profiles
        $data['profiles'] = $profileModel->getAllProfiles();

        // Load the view with profiles
        return view('profilepermission', $data);
    }

    public function getPermissionsByProfile($profileId)
    {
        // Load the ProfileModel
        $profileModel = new ProfileModel();

        // Get dashboard permissions by profile
        $permissions = $profileModel->getDashboardPermissionsByProfile($profileId);

        // Return JSON response
        return $this->response->setJSON($permissions);
    }
}
