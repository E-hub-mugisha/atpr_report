@extends('layouts.app')
@section('title', 'Intakes')
@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Intakes</h4>
            <div class="nk-block-des">
                <p>List of all intakes.</p>
                <!-- add intake button modal -->
                 <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIntakeModal">Add Intake</button>
            </div>
        </div>
    </div>
    <div class="card card-preview">
        <div class="card-inner">
            <table class="datatable-init table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($intakes as $intake)
                    <tr>
                        <td>{{ $intake->id }}</td>
                        <td>{{ $intake->month }}/{{ $intake->year }}</td>
                        <td>{{ $intake->start_date->format('d M Y') }}</td>
                        <td>{{ $intake->end_date->format('d M Y') }}</td>
                        <td>{{ $intake->status }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editIntakeModal{{ $intake->id }}">Edit</button>
                            <!-- delete button -->
                             <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteIntakeModal{{ $intake->id }}">Delete</button>
                        </td>
                    </tr>

                    <!-- Edit Intake Modal -->
                    <div class="modal fade" tabindex="-1" id="editIntakeModal{{ $intake->id }}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                                <div class="modal-body modal-body-lg">
                                    <h5 class="title">Edit Intake</h5>
                                    <form action="{{ route('intakes.update', $intake->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                         <!-- month  -->
                                        <div class="form-group">
                                            <label class="form-label" for="month">Intake Month</label>
                                            <select class="form-control" id="month" name="month" required>
                                                <option value="01" {{ $intake->month == '01' ? 'selected' : '' }}>January</option>
                                                <option value="02" {{ $intake->month == '02' ? 'selected' : '' }}>February</option>
                                                <option value="03" {{ $intake->month == '03' ? 'selected' : '' }}>March</option>
                                                <option value="04" {{ $intake->month == '04' ? 'selected' : '' }}>April</option>
                                                <option value="05" {{ $intake->month == '05' ? 'selected' : '' }}>May</option>
                                                <option value="06" {{ $intake->month == '06' ? 'selected' : '' }}>June</option>
                                                <option value="07" {{ $intake->month == '07' ? 'selected' : '' }}>July</option>
                                                <option value="08" {{ $intake->month == '08' ? 'selected' : '' }}>August</option>
                                                <option value="09" {{ $intake->month == '09' ? 'selected' : '' }}>September</option>
                                                <option value="10" {{ $intake->month == '10' ? 'selected' : '' }}>October</option>
                                                <option value="11" {{ $intake->month == '11' ? 'selected' : '' }}>November</option>
                                                <option value="12" {{ $intake->month == '12' ? 'selected' : '' }}>December</option>
                                            </select>
                                        </div>
                                        <!-- year -->
                                         <div class="form-group">
                                            <label class="form-label" for="year">Intake Year</label>
                                            <select class="form-control" id="year" name="year" required>
                                                @for ($year = date('Y'); $year <= date('Y') + 5; $year++)
                                                    <option value="{{ $year }}" {{ $intake->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="start_date">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $intake->start_date->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="end_date">End Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $intake->end_date->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="name">Intake status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="open" {{ $intake->status == 'open' ? 'selected' : '' }}>Open</option>
                                                <option value="closed" {{ $intake->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update Intake</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delete Intake Modal -->
                    <div class="modal fade" tabindex="-1" id="deleteIntakeModal{{ $intake->id }}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                                <div class="modal-body modal-body-lg">
                                    <h5 class="title">Delete Intake</h5>
                                    <p>Are you sure you want to delete the intake {{ $intake->month }}/{{ $intake->year }}?</p>
                                    <form action="{{ route('intakes.destroy', $intake->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Intake Modal   -->
<div class="modal fade" tabindex="-1" id="addIntakeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Add New Intake</h5>
                <form action="{{ route('intakes.store') }}" method="POST">
                    @csrf 
                     <!-- month  -->
                    <div class="form-group">
                        <label class="form-label" for="month">Intake Month</label>
                        <select class="form-control" id="month" name="month" required>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <!-- year -->
                     <div class="form-group">
                        <label class="form-label" for="year">Intake Year</label>
                        <select class="form-control" id="year" name="year" required>
                            @for ($year = date('Y'); $year <= date('Y') + 5; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">Intake status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Intake</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection