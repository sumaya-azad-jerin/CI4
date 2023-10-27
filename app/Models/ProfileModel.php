<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'profile_id';

    public function getAllProfiles()
    {
        return $this->findAll();
    }

    public function getDashboardPermissionsByProfile($profileId)
    {
        $builder = $this->db->table('profiledashboard');
        $builder->select('profiledashboard_id, add_dashboard, view_dashboard, edit_dashboard, delete_dashboard');
        $builder->where('profile_id', $profileId);

        $permissions = $builder->get()->getResultArray();

        return $permissions;
    }
}
