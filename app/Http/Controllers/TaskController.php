<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        //TODO add authorization check

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('title', 'LIKE', "%{$value}%");
            });
        });

        $tasks = QueryBuilder::for(Task::class)
            ->defaultSort('id')
            ->allowedSorts(['title', 'completed', 'due_date'])
            ->allowedFilters(['title', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
        ])->table(function (InertiaTable $table) {
            $table->addSearchRows([
                'title' => 'Title',
            ]);
        });
    }

    public function show(Request $request, Task $task)
    {
        //TODO add authorization check
        $task->human_due_date = Carbon::parse($task->due_date)->diffForHumans();
        $task->human_created_at = Carbon::parse($task->created_at)->diffForHumans();
        $task->human_updated_at = Carbon::parse($task->updated_at)->diffForHumans();
        return Inertia::render('Tasks/Show', [
            'task' => $task
        ]);
    }

    public function completed(Request $request, Task $task)
    {
        $task->completed = 1;
        $task->save();
        return redirect()->back();
    }

    public function in_progress(Request $request, Task $task)
    {
        $task->completed = 0;
        $task->save();
        return redirect()->back();
    }

    public function create(Request $request)
    {
        //TODO add authorization check

        return Inertia::render('Tasks/Create');
    }

    public function store(Request $request)
    {
        //TODO add authorization check

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'due_date' => 'required|date',
        ]);

        $task = Task::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.show', $task->id);
    }

    public function edit(Request $request, Task $task)
    {
        //TODO add authorization check

        return Inertia::render('Tasks/Edit', [
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        //TODO add authorization check

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'due_date' => 'required|date',
            'completed' => 'boolean',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'completed' => $request->completed,
        ]);

        return redirect()->route('tasks.show', $task->id);
    }

    public function destroy(Request $request, Task $task)
    {
        //TODO add authorization check

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
