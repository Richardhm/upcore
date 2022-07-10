<?php
    namespace App\Models\Traits;
    use Illuminate\Support\Facades\DB;
    trait UserACLTrait
    {
        public function permissionsACL()
        {
            $pp = [];
            $permissions = $this->permissions()->with('permission')->get();
            foreach($permissions as $p) {
                array_push($pp,$p->permission->name);    
            }
            return $pp;
        }

        public function hasPermission(string $permissionName)
        {
            return in_array($permissionName,$this->permissionsACL());
        }

        public function isAdmin()
        {   
            $admins = DB::select("SELECT * FROM users WHERE admin = ?",[1]);
            $emails = [];
            foreach($admins as $a) {
                array_push($emails,$a->email);
            }
            
            return in_array($this->email,$emails);   
        }




    }