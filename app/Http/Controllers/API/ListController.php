<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\SimpleCourseListResource;
use App\Http\Resources\Lesson\SimpleLessonListResource;

class ListController extends Controller
{
    /**
     * get courses list
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function courses(Request $request)
    {
        return SimpleCourseListResource::collection(
            Course::query()
                ->select('id', 'title')
                ->with('coverImage:id,path')
                ->filter($request)
                ->orderBy('title')
                ->get()
        );
    }

    /**
     * get lesson list by course
     * 
     * @param string $courseId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function lessonsByCourse(Request $request, string $courseId)
    {
        return SimpleLessonListResource::collection(
            Lesson::query()
                ->select('id', 'title', 'content')
                ->where('course_id', $courseId)
                ->filter($request)
                ->with('coverImage:id,path')
                ->orderBy('order')
                ->get()
        );
    }
}
