<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Student;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class StudentController extends Controller
{
    /** index page student list */
    public function student()
    {
        $studentList = Student::all();
        return view('student.student',compact('studentList'));
    }

    /** index page student grid */
    public function studentGrid()
    {
        $studentList = Student::all();
        return view('student.student-grid',compact('studentList'));
    }

    /** student add page */
    public function studentAdd()
    {
        return view('student.add-student');
    }

    /** student save record */
    public function studentSave(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|string',
            'roll'          => 'required|string',
            'blood_group'   => 'required|string',
            'religion'      => 'required|string',
            'email'         => 'required|email',
            'class'         => 'required|string',
            'section'       => 'required|string',
            'admission_id'  => 'required|string',
            'phone_number'  => 'required',
            'upload'        => 'required|image',
        ]);

        DB::beginTransaction();
        try {

            $upload_file = rand() . '.' . $request->upload->extension();
            $request->upload->move(storage_path('app/public/student-photos/'), $upload_file);
            if(!empty($request->upload)) {
                $student = new Student;
                $student->first_name   = $request->first_name;
                $student->last_name    = $request->last_name;
                $student->gender       = $request->gender;
                $student->date_of_birth= $request->date_of_birth;
                $student->roll         = $request->roll;
                $student->blood_group  = $request->blood_group;
                $student->religion     = $request->religion;
                $student->email        = $request->email;
                $student->class        = $request->class;
                $student->section      = $request->section;
                $student->admission_id = $request->admission_id;
                $student->phone_number = $request->phone_number;
                $student->upload = $upload_file;
                $student->save();

                Toastr::success('Has been add successfully :)','Success');
                DB::commit();
            }

            return redirect()->back();

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new student  :)','Error');
            return redirect()->back();
        }
    }

    /** view for edit student */
    public function studentEdit($id)
    {
        $studentEdit = Student::where('id',$id)->first();
        return view('student.edit-student',compact('studentEdit'));
    }

    /** update record */
    public function studentUpdate(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->upload)) {
                unlink(storage_path('app/public/student-photos/'.$request->image_hidden));
                $upload_file = rand() . '.' . $request->upload->extension();
                $request->upload->move(storage_path('app/public/student-photos/'), $upload_file);
            } else {
                $upload_file = $request->image_hidden;
            }

            $updateRecord = [
                'upload' => $upload_file,
            ];
            Student::where('id',$request->id)->update($updateRecord);

            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update student  :)','Error');
            return redirect()->back();
        }
    }

    /** student delete */
    /** student delete */
    public function deleteStudent($id)
    {
        DB::beginTransaction();
        try {
            // Tìm sinh viên theo ID
            $student = Student::find($id);

            // Nếu sinh viên không tồn tại, trả về thông báo lỗi
            if (!$student) {
                Toastr::error('Student not found :(', 'Error');
                return;
            }

            // Xóa hình ảnh sinh viên nếu có
            if (!empty($student->upload)) {
                unlink(storage_path('app/public/student-photos/' . $student->upload));
            }

            // Xóa sinh viên từ cơ sở dữ liệu
            $student->delete();

            // Commit transaction và hiển thị thông báo thành công
            DB::commit();
            Toastr::success('Student deleted successfully :)', 'Success');

            // Gửi sự kiện để làm mới trang
            $this->emit('refreshPage');

        } catch (\Exception $e) {
            // Nếu xảy ra lỗi, rollback transaction và hiển thị thông báo lỗi
            DB::rollback();
            Toastr::error('Failed to delete student :(', 'Error');
        }
    }

    public function deleteStudentConfirmed($id)
    {
        $this->deleteStudent($id);
    }


    /** student profile page */
    public function studentProfile($id)
    {
        $studentProfile = Student::where('id',$id)->first();
        return view('student.student-profile',compact('studentProfile'));
    }
}
