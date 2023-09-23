@extends('layouts.app')

@section('title', 'Todo Tasks');


@section('content')
    <div class="container bg-red-900 px-2  items-top justify-center  sm:items-center py-4 sm:pt-0">


        <div class="form-check my-4">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input show_all"  value="checkedValue">
                Show All Task
            </label>
        </div>
        @if ($errors->has('task'))
            <span>{{ $errors->first('task') }}</span>
        @endif
        <form action="{{ route('task.store') }}" method="Post" id="addForm">
            @csrf




            <span class="error-message text-danger"></span>

            <div class="input-group">

                <input type="text" name="task" class="form-control" placeholder="Project #To DO">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Add</button>
                </div>
            </div>

            <!-- Other form elements go here -->

        </form>

        <table class="table table-bordered table-inverse table-responsive my-4">

            <tbody>


                    @foreach ($taskLists as $task)
                        <tr id="task_{{ $task->id }}">
                            <td scope="row">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input task" type="checkbox" data-Id="{{ $task->id }}"
                                            value="checkedValue" {{ $task->is_completed == 0 ? 'checked' : '' }}>
                                    </label>
                                </div>
                            </td>
                            <td>{{ $task->task_name }}</td>
                            <td> <i class="fa fa-user-circle" aria-hidden="true"></i></i></td>
                            <td>
                                <form action="{{ route('task.destroy', $task->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>

                            </td>

                        </tr>
                    @endforeach





            </tbody>
        </table>

    </div>
@endsection
@section('script')
    @include('task_script');
@endsection
