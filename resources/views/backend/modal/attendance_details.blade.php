<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
        <div class="modal-content data">
            <div class="modal-header text-center modal_headerBg_color">
                <h5 class="modal-title">{{ $data['title'] }}</h5>
                {{-- <button type="button" class="close text-white break_close btn-close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button> --}}

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-5">
                    <div class="col-md-12">
                        <table class="table table-bordered" >
                            <thead>
                                <tr class="border-bottom-custom">
                                    <th colspan="4" class="text-center">{{ _trans('attendance.Check In') }}</th>
                                    <th colspan="4" class="text-center">{{ _trans('attendance.Check Out') }}</th>
                                </tr>
                                <tr class="border-bottom-custom">
                                    <th>{{ _trans('common.Time') }}</th>
                                    <th>{{ _trans('common.Reason') }}</th>
                                    <th>{{ _trans('common.Location') }}</th>
                                    <th>{{ _trans('common.Approve') }}</th>
                                    <th>{{ _trans('common.Time') }}</th>
                                    <th>{{ _trans('common.Reason') }}</th>
                                    <th>{{ _trans('common.Location') }}</th>
                                    <th>{{ _trans('common.Approve') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['attendance'] as $attendance)
                                <tr>
                                    <td>{{ @dateTimeIn($attendance->check_in) }}</td>
                                    <td>{{ @$attendance->lateInReason->reason }}</td>
                                    <td>{{ @$attendance->check_in_location }}</td>
                                    <td>
                                        @if(@$attendance->lateInReason->reason && !@$attendance->in_status_approve)
                                            <a href={{route('attendance.checkInOutApprovalOnTime', [$attendance->id, 'checkin'])}} class="btn btn-success btn-sm"> 
                                                Approve
                                            </a>
                                        @elseif(@$attendance->lateInReason->reason && @$attendance->in_status_approve === 'OT')
                                            <a href="" class="btn btn-success btn-sm disabled">
                                            {{-- <i class="fa fa-check"></i>  --}}
                                            Approved</a>
                                        @else
                                            <a href="" class="btn btn-danger btn-sm disabled"> Approve</a>
                                        @endif
                                    </td>
                                    <td>{{ dateTimeIn($attendance->check_out) }}</td>
                                    <td>{{ @$attendance->earlyOutReason->reason }}</td>
                                    <td>{{ @$attendance->check_out_location }}</td>
                                    <td>
                                        @if(@$attendance->earlyOutReason->reason && !@$attendance->out_status_approve)
                                            <a href={{route('attendance.checkInOutApprovalOnTime', [$attendance->id, 'checkout'])}} class="btn btn-success btn-sm">
                                                Approve
                                            </a>
                                        @elseif(@$attendance->earlyOutReason->reason && @$attendance->out_status_approve === 'LT')
                                            <a href="" class="btn btn-success btn-sm disabled">
                                            {{-- <i class="fa fa-check"></i>  --}}
                                            Approved</a>
                                        @else
                                            <a href="" class="btn btn-danger btn-sm disabled"> Approve</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="col-md-6">
                        <label class="text-primary">Check In</label> &nbsp;
                        
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Check Out</label> &nbsp;
                        <button type="button" class="btn btn-success"><i class="fa fa-check"></i> Approve  Timely Left</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
