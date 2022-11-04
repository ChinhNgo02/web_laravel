<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\DestroyRequest;
use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use Yajra\Datatables\Datatables;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    private Builder $model;
    private string $title = 'Course';
    public function __construct()
    {
        $this->model = (new Course())->query();
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);
        View::share('title', $title);
    }

    public function index(Request $request)
    {
        // $search = $request->get('q');
        // $data = Course::Where('name', 'like', '%' . $search . '%')->paginate(2);
        // $data->appends(['q' => $search]);
        // return view('course.index', [
        //     'data' => $data,
        //     'search' => $search,
        // ]);
        return view('course.index');
    }

    public function api()
    {
        return Datatables::of($this->model->withCount('students'))
            ->editColumn('created_at', function ($object) {
                return $object->year_created_at;
            })
            ->addColumn('edit', function ($object) {
                return route('course.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('course.destroy', $object);
            })
            ->make(true);
    }

    public function apiName(Request $request)
    {
        return $this->model->Where('name', 'like', '%' . $request->get('q') . '%')->get([
            'id',
            'name',
        ]);
    }

    public function create()
    {
        return view('course.create');
    }

    public function store(StoreRequest $request)
    {
        // $object = new Course();
        // $object->fill($request->except('_token'));
        // $object->save();
        // dd($request->validated());
        $this->model->create($request->validated());

        return redirect()->route('course.index');
    }

    public function show(Course $course)
    {
        //
    }

    public function edit(Course $course)
    {
        return view('course.edit', [
            'each' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $courseId)
    {
        // Course::where('id', $course->id)->update(
        //     $request->except([
        //         '_token',
        //         '_method',
        //     ])
        // );
        //  $course->update(
        //     $request->except([
        //         '_token',
        //         '_method',
        //     ])
        // );
        $object = $this->model->find($courseId);
        $object->fill($request->validated());
        $object->save();
        return redirect()->route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRequest $request, $courseId)
    {
        // $course->delete();
        // $this->model->find($courseId)->delete();
        $this->model->Where('id', $courseId)->delete();
        // return redirect()->route('course.index');
        $arr = [];
        $arr['status'] = true;
        $arr['message'] = '';
        return response($arr, 200);
    }
}