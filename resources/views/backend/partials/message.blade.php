<script >
    @foreach (session('flash_notification', collect())->toArray() as $message)
    cuteToast({
        type: "{{ $message['level'] == 'success' ? 'success' : 'error' }}",
        message: '{{ $message['message'] }}',
        timer: 2000,
    });
    @endforeach

    @if (Session::has('alert'))
    cuteToast({
        type: "warning",
        message: "{{ Session::get('alert') }}",
        timer: 2000,
    });
    @endif
    @if (Session::has('error'))
    cuteToast({
        type: "error",
        message: "{{ Session::get('error') }}",
        timer: 2000,
    });
    @endif
    @if (Session::has('success'))
    cuteToast({
        type: "success",
        message: "{{ Session::get('success') }}",
        timer: 2000,
    });
    @endif
    @if (Session::has('warning'))
    cuteToast({
        type: "warning",
        message: "{{ Session::get('warning') }}",
        timer: 2000,
    });
    @endif
    @if (Session::has('info'))
    cuteToast({
        type: "info",
        message: "{{ Session::get('info') }}",
        timer: 2000,
    });
    @endif
</script>

