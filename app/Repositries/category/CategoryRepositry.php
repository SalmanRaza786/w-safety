<?php

namespace App\Repositries\category;

use App\Http\Helpers\Helper;
use App\Models\Category;
use App\Models\Country;
use App\Models\Slider;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use DataTables;


class CategoryRepositry implements CategoryInterface
{
    protected $categoryFilePath = 'category-media/';
    protected $categoryFileName = "";
    use HandleFiles;
    public function updateOrCreate($request,$id)
    {

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
            ]);
            if ($validator->fails())
                return Helper::errorWithData($validator->errors()->first(), $validator->errors());

            if($request->file('cat_image')){
                $this->categoryFileName = $this->handleFiles($request->file('cat_image'), $this->categoryFilePath);
            }

            $role = Category::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'title' => $request->title,
                    'image' => $this->categoryFileName,

                ]
            );

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();


            return Helper::success($role, $message);
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }


    public function getCategory($request)
    {
        try {
            $data['totalRecords'] = Category::count();
            $qry= Category::query();

            $qry=$qry->when($request->s_title, function ($query, $title) {
                return $query->where('name',$title);
            });
            $qry=$qry->when($request->s_status, function ($query, $s_status) {
                return $query->where('status',$s_status);
            });

            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data'] =$qry->orderByDesc('id')->get();

            if (!empty($request->get('s_title')) OR !empty($request->get('s_status')) ) {

                $qry= Category::query();
                $qry=$qry->when($request->s_title, function ($query, $title) {
                    return $query->where('name',$title);
                });
                $qry=$qry->when($request->s_status, function ($query, $s_status) {
                    return $query->where('status',$s_status);
                });
                $data['totalRecords']=$qry->count();
            }
            return Helper::success($data, $message="Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
    public function deleteCategory($id)
    {
        try {
            $role = Category::find($id);
            $role->delete();
            return Helper::success($role, $message=__('translation.record_deleted'));
        } catch (ValidationException $validationException) {
            DB::rollBack();
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        }

    }
    public function findCategoryById($id)
    {
        try {
             $res = Category::find($id);
            return Helper::success($res, $message='Record found');
            } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
             }
    }
    public function getAllCategories()
    {
        try {

            $qry= Category::query();
            $data =$qry->get();
            return Helper::success($data, $message="Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getAllCountries()
    {
        try {

            $qry= Country::query();
            $data =$qry->get();
            return Helper::success($data, $message="Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getAllSliders()
    {
        try {

            $qry= Slider::query();
            $data =$qry->get();
            return Helper::success($data, $message="Sliders list");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function getAllCategoriesWithProducts()
    {
        try {

            $qry= Category::query();
            $qry=$qry->with('products');
            $data =$qry->get();
            return Helper::success($data, $message="Record found");

        }  catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
}
