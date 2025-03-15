<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';
    protected $fillable = [
       'first_registration_code', 'eobi_amount','provident_amount','eobi_govt_id','medical_allowances','conveyance','house_rent','EOBI','provident_fund','filer_type','ntn','created_by', 'last_updated_by', 'reg_no', 'branch_id', 'join_date', 'designation', 'first_name',  'middle_name', 'last_name','working_hours',
        'father_name', 'mother_name', 'date_of_birth', 'gender', 'blood_group', 'nationality', 'mother_tongue', 'address', 'country', 'city',
        'temp_address', 'home_phone', 'mobile_1', 'mobile_2', 'email', 'qualification','payment_type','role_id',
        'experience', 'other_info', 'staff_image', 'skill', 'cnic', 'status', 'job_status', 'password', 'salary','basic_salary','staff_type_id', 'staff_type', 'user_id', 'salary_per_hour','probation','end_day_contract','start_day_contract','account_title', 'bank_id', 'is_iban', 'account_number','bank_branch','bank_account','tax_percentage','epf','eobi','relation','pemail','marital_status','expiry_date','class_level','sos_reason','sos_date','epf_opening_amount','eobi_opening_amount','payment_type','updated_by'
    ];
    // public function payrollMaster()
    // {
    //     return $this->hasMany(PayrollMaster::class, 'staff_id');
    // }

    // public function paySalary()
    // {
    //     return $this->hasMany(SalaryPay::class, 'staff_id');
    // }
    static public  function employeeDetailByUserId($user_id){
        $Employees  = Staff::where(['user_id' => $user_id])
            ->first();
           // dd($Employees);
        return $Employees;
    }
    static public function pluckActiveOnly() {
        return self::OrderBy('first_name','asc')->get()->pluck('first_name','user_id');
    }
    static public function pluckActiveWithID() {
        return self::where(['status' => 1])->OrderBy('first_name','asc')->get()->pluck('first_name','user_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    public function staffType()
    {
        return $this->belongsTo(StaffType::class, 'staff_type_id');
    }

    public function user()
    {
        return $this->belongsTo("App\User", 'user_id');
    }

    public function stafftransferbranch()
    {
        return $this->hasOne("App\Models\HRM\StaffTransferBranch", 'user_id', "user_id");
    }

    public function role()
    {
        return $this->hasOne("App\Models\ModelHasRoles", 'model_id', "user_id");
    }

    public function activesession()
    {
        return $this->hasMany("App\Models\Academics\ActiveSession", 'branch_id', "branch_id");
    }
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function employee_designation()
    {
        return $this->belongsTo('App\Models\Designation','designation','id');
    }
    public function branches()
    {
        return $this->belongsToMany(StaffBranches::class, 'staff_branches', 'staff_id', 'branch_id');
    }
}
