<?php
namespace App\Repositries\customer;

use App\Http\Helpers\Helper;

use App\Models\Admin;
use App\Models\LoadType;
use App\Models\User;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DataTables;


class CustomerRepositry implements CustomerInterface {
    use HandleFiles;

    protected $imagePath = 'user-media/';
    protected $imageName = "";

    public function getcustomerList($request)
    {
        try {
            $data['totalRecords'] = User::count();
            $qry= User::query();

            $qry=$qry->when($request->s_name, function ($query, $name) {
                return $query->where('name', 'LIKE', "%{$name}%")
                    ->orWhere('email','LIKE',"%{$name}%");
            });


            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();

            if (!empty($request->get('s_name')) ) {
                $data['totalRecords']=$qry->count();
            }
            return Helper::success($data, $message="Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function customerSave($request,$id)
    {
        try {

            DB::beginTransaction();

            if($request->file('photo')){
                $this->imageName = $this->handleFiles($request->file('photo'), $this->imagePath);
            }

            $customerData = [
                'name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'address' => $request->address,
                'neighborhood_commune' => $request->address,
                'identity_document' => $request->address,
                'photo' =>$this->imageName,
            ];

            if ($request->filled('password')) {
                $customerData['password'] = $request->password;
            }

            $load = User::updateOrCreate(
                [
                    'id' => $id
                ],
                $customerData
            );

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($load, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }

    public function deletecustomer($id)
    {
        try {
            $role = User::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function editcustomer($id)
    {
        try {
            $res = User::findOrFail($id);
            return Helper::success($res, $message='Record found');
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }
    }

    public function getAllCustomers()
    {
        try {
            $qry= User::query();
            $data=$qry->orderByDesc('id')->get();
            return Helper::success($data, $message="Record found");
        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

}





