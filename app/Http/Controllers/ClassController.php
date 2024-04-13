<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ClassController extends Controller
{
    /**
     * Hiển thị danh sách các lớp.
     *
     * @return \Illuminate\Http\Response
     */
    public function classes()
    {
        $classList = Classes::all();
        return view('classes.classes', compact('classList'));
    }

    /**
     * Hiển thị form để thêm mới lớp học.
     *
     * @return \Illuminate\Http\Response
     */
    public function classesAdd()
    {
        return view('classes.add-class');
    }

    /**
     * Lưu lớp học mới vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function classesSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantityStudent' => 'required|integer|min:0',
            'startDate' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $classes = new Classes;
            $classes->name = $request->name;
            $classes->quantityStudent = $request->quantityStudent;
            $classes->startDate = $request->startDate;
            $classes->save();
            DB::commit();
            Toastr::success('Class added successfully :)', 'Success');
            return redirect()->route('classes/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add class :(', 'Error');
            return redirect()->route('classes/list');
        }
    }

    /**
     * Hiển thị thông tin của lớp học để chỉnh sửa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function classesEdit($id)
    {
        $classesEdit = Classes::find($id);
        return view('classes.edit-class', compact('classesEdit'));
    }

    /**
     * Cập nhật thông tin của lớp học trong cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function classesUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantityClasses' => 'required|integer|min:0',
            'startDate' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $classes = Classes::find($id);
            $classes->name = $request->name;
            $classes->quantityClasses = $request->quantityClasses;
            $classes->startDate = $request->startDate;
            $classes->save();
            DB::commit();
            Toastr::success('Class updated successfully :)', 'Success');
            return redirect()->route('classes/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update class :(', 'Error');
            return redirect()->route('classes/list');
        }
    }

    /**
     * Xóa lớp học khỏi cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');

        $class = Classes::find($id);
        if (!$class) {
            Toastr::error('Class not found.', 'Error');
            return redirect()->route('classes/list');
        }

        try {
            $class->delete();
            Toastr::success('Class has been deleted successfully.', 'Success');
            return redirect()->route('classes/list');
        } catch (\Exception $e) {
            Toastr::error('An error occurred while deleting the class.', 'Error');
            return redirect()->route('classes/list');
        }
    }
}

