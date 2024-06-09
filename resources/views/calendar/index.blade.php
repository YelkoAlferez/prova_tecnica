@extends('layouts.app')
@push('styles')
    <style>
        #calendar{
            width:90%;
            height:85vh;
            margin:auto;
        }
        #create{
            width:10%;
            margin: 10px auto;
        }
    </style>
@endpush
@push('scripts')
    <script src="
    https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js
    "></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($calendars),
                dateClick: function(info) {
                    {{-- Cuando pulse una fecha, mostramos el formulario pasando por parámetro la fecha en cuestión --}}
                    var url = '{{ route('calendar.create') }}?date=' + info.dateStr;
                    window.location.href = url;
                }
            });
            calendar.render();
        });
    </script>
@endpush
@section('content')
    <div id="calendar">
    </div>
@endsection
