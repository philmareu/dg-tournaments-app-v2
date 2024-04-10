<?php

namespace App\Http\Controllers\Endpoints;

use App\Events\CourseAddedToTournament;
use App\Events\CourseCreated;
use App\Http\Requests\Manager\DestroyTournamentCourseRequest;
use App\Http\Requests\Manager\StoreTournamentCourseRequest;
use App\Http\Requests\Manager\UpdateTournamentCourseHolesRequest;
use App\Http\Requests\Manager\UpdateTournamentCourseRequest;
use App\Http\Resources\TournamentCourse as TournamentCourseResource;
use App\Models\Course;
use App\Models\Tournament;
use App\Models\TournamentCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TournamentCoursesEndpointController extends Controller
{
    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;

        $this->middleware('auth')->except('show');
    }

    public function show(TournamentCourse $tournamentCourse)
    {
        return new TournamentCourseResource($tournamentCourse);
    }

    public function store(StoreTournamentCourseRequest $request, Tournament $tournament)
    {
        if($request->filled('course_id')) $course = $this->course->find($request->course_id);
        else $course = $this->createNewCourse($request->all());

        $tournamentCourse = new TournamentCourse($request->all());
        $tournamentCourse->course()->associate($course);
        $tournamentCourse->tournament()->associate($tournament);
        $tournamentCourse->save();

        return $tournament->load('courses')->courses;
    }

    public function update(UpdateTournamentCourseRequest $request, TournamentCourse $tournamentCourse)
    {
        $tournamentCourse->update($request->only([
            'name',
            'holes',
            'latitude',
            'longitude',
            'address',
            'address_2',
            'city',
            'state_province',
            'country',
            'directions',
            'notes'
        ]));

        return $tournamentCourse;
    }

    public function destroy(DestroyTournamentCourseRequest $request, TournamentCourse $tournamentCourse)
    {
        $tournamentCourse->delete();

        return $tournamentCourse->tournament->load('courses')->courses;
    }

    public function holes(UpdateTournamentCourseHolesRequest $request, TournamentCourse $tournamentCourse)
    {
        collect($request->notes)->filter(function($note) {
            return $note !== '';
        })->each(function($note, $hole) use ($tournamentCourse) {
            $existingHole = $tournamentCourse->holeNotes->where('hole', $hole)->first();

            if(empty($existingHole)) $tournamentCourse->holeNotes()->create(['hole' => $hole, 'notes' => $note]);
            else $existingHole->update(['notes' => $note]);
        });

        return $tournamentCourse->load('holeNotes')->holeNotes->groupBy('hole');
    }

    private function createNewCourse(array $attributes)
    {
        $attributes = array_merge($attributes, ['slug' => str_slug($attributes['name'])]);
        $course = $this->course->create($attributes);

        event(new CourseCreated($course));

        return $course;
    }
}
