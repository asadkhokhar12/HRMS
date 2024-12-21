@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row my-3 mb-5">
                <div class="col-md-12">
                    <div class="">
                        <label class="label">Employee:</label>
                        <select id="userDropdown" name="userDropdown" class="form-select form-select-sm">
                            <option hidden value="">Select employee</option>
                            @foreach($employee as $user)
                                <option value="{{ $user->id }}" class="fw-bold">{{ $user->name }} [ {{ $user->email}} ] </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="loader text-center my-4">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="calendar"></div>
        </div>
    </div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.loader').hide();

        var calendar = $('#calendar').fullCalendar({
            editable: false,
            initialView: 'dayGridMonth',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,listWeek'
            },
            events: function(start, end, timezone, callback) {
                
                // Fetch events dynamically based on selected user
                var userId = $('#userDropdown').val(); // Get selected user ID
                $.ajax({
                    url: "{{ route('full.calender') }}",
                    data: { 
                        user_id: userId,
                        start: start.format(), // Format start date
                        end: end.format()      // Format end date 
                    },
                    beforeSend:function(){
                        $('.loader').show();
                    },
                    complete:function(){
                        $('.loader').hide();
                    },
                    success: function(data) {
                        callback(data); // Pass events to the calendar
                    },
                    error: function(error) {
                        console.error('Error fetching events:', error);
                    }
                });
            },
            selectable: false,
            selectHelper: false,
            // hiddenDays: [0, 6], // Hides Sundays (0) and Saturdays (6)
        });

        // User Dropdown Change Event
        $('#userDropdown').on('change', function() {
            $('#calendar').fullCalendar('refetchEvents'); // Reload events for selected user
        });
    });
</script>
@endsection

