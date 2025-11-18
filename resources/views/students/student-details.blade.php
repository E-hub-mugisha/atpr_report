@extends('layouts.app')
@section('title', $student->full_name . 'Student detail')

@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Student / <strong class="text-primary small">{{ $student->full_name }}</strong></h3>
                        <div class="nk-block-des text-soft">
                            <ul class="list-inline">
                                <li>Student ID: <span class="text-base">{{ $student->student_id}}</span></li>
                                <li>Academic Year: <span class="text-base">{{ $student->academic_year}}</span></li>
                                <li>Intake: <span class="text-base">{{ $student->intake->month }}/{{ $student->intake->year }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nk-block-head-content"><a href="{{ route('students.index') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a><a href="user-list-regular.html" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a></div>
                </div>
            </div>
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-aside-wrap">
                        <div class="card-content">
                            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                <li class="nav-item"><a class="nav-link active" href="#"><em class="icon ni ni-user-circle"></em><span>Personal</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#"><em class="icon ni ni-repeat"></em><span>Marks</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#"><em class="icon ni ni-file-text"></em><span>Attendance</span></a>
                                </li>
                                <li class="nav-item nav-item-trigger d-xxl-none"><a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a></li>
                            </ul>
                            <div class="card-inner">
                                <div class="nk-block">
                                    <div class="nk-block-head">
                                        <h5 class="title">Personal Information</h5>
                                        <p>Basic info, like your name and address, that you use on
                                            Nio Platform.</p>
                                    </div>
                                    <div class="profile-ud-list">
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Title</span><span class="profile-ud-value">Mr.</span></div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Full Name</span><span class="profile-ud-value">{{ $student->full_name}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider">
                                                <span class="profile-ud-label">
                                                    Date of Birth
                                                </span>
                                                <span class="profile-ud-value">
                                                    {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M, Y') : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Gender</span><span class="profile-ud-value">{{ $student->gender}}</span></div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Mobile
                                                    Number</span><span class="profile-ud-value">{{ $student->phone}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Email
                                                    Address</span><span class="profile-ud-value">{{ $student->email}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block">
                                    <div class="nk-block-head nk-block-head-line">
                                        <h6 class="title overline-title text-base">Additional
                                            Information</h6>
                                    </div>
                                    <div class="profile-ud-list">
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Education Level</span><span class="profile-ud-value">{{ $student->education_level}}</span></div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Marital Status</span><span class="profile-ud-value">{{ $student->marital_status}}</span></div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Address</span><span class="profile-ud-value">{{ $student->address}}</span>
                                            </div>
                                        </div>
                                        <div class="profile-ud-item">
                                            <div class="profile-ud wider"><span class="profile-ud-label">Disability</span><span class="profile-ud-value">{{ $student->disability ? 'Yes' : 'No' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-divider divider md"></div>
                                <div class="nk-block">
                                    <div class="nk-block-head nk-block-head-sm nk-block-between">
                                        <h5 class="title">Admin Note</h5><a href="#" class="link link-sm">+ Add Note</a>
                                    </div>
                                    <div class="bq-note">
                                        <div class="bq-note-item">
                                            <div class="bq-note-text">
                                                <p>Aproin at metus et dolor tincidunt feugiat eu id
                                                    quam. Pellentesque habitant morbi tristique
                                                    senectus et netus et malesuada fames ac turpis
                                                    egestas. Aenean sollicitudin non nunc vel
                                                    pharetra. </p>
                                            </div>
                                            <div class="bq-note-meta"><span class="bq-note-added">Added on <span class="date">November 18, 2019</span> at
                                                    <span class="time">5:34 PM</span></span><span class="bq-note-sep sep">|</span><span class="bq-note-by">By
                                                    <span>Softnio</span></span><a href="#" class="link link-sm link-danger">Delete Note</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl toggle-screen-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                            <div class="card-inner-group" data-simplebar="init">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                <div class="simplebar-content" style="padding: 0px;">
                                                    <div class="card-inner">
                                                        <div class="user-card user-card-s2">
                                                            <div class="user-avatar lg bg-primary"><span>AB</span></div>
                                                            <div class="user-info">
                                                                <div class="badge bg-outline-light rounded-pill ucap">
                                                                    {{ $student->qualification_title}}
                                                                </div>
                                                                <h5>{{ $student->full_name}}</h5><span class="sub-text">{{ $student->email }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-inner card-inner-sm">
                                                        <ul class="btn-toolbar justify-center gx-1">
                                                            <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-shield-off"></em></a></li>
                                                            <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-mail"></em></a></li>
                                                            <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-download-cloud"></em></a></li>
                                                            <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-bookmark"></em></a></li>
                                                            <li><a href="#" class="btn btn-trigger btn-icon text-danger"><em class="icon ni ni-na"></em></a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-inner">
                                                        <div class="row text-center">
                                                            <div class="col-4">
                                                                <div class="profile-stats"><span class="amount">23</span><span class="sub-text">Total Order</span></div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="profile-stats"><span class="amount">20</span><span class="sub-text">Complete</span></div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="profile-stats"><span class="amount">3</span><span class="sub-text">Progress</span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-inner">
                                                        <h6 class="overline-title-alt mb-2">Additional</h6>
                                                        <div class="row g-3">
                                                            <div class="col-6"><span class="sub-text">Student
                                                                    ID:</span><span>{{ $student->student_id}}</span></div>
                                                            <div class="col-6"><span class="sub-text">Last
                                                                    Login:</span><span>15 Feb, 2019 01:02 PM</span>
                                                            </div>
                                                            <div class="col-6"><span class="sub-text">
                                                                    Status:</span><span class="lead-text text-success">{{ $student->status }}</span></div>
                                                            <div class="col-6"><span class="sub-text">Register
                                                                    At:</span><span>Nov 24, 2019</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: 379px; height: 819px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection