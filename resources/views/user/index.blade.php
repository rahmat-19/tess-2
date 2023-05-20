@extends('layouts.app-dashboard')
@section('content')
<div id="user-index" />
<script>
    if (document.cookie.includes('token')) {
        // Cookie exists
        var cookieValue = getCookie('token');
        console.log('Cookie value: ' + cookieValue);
    } else {
        // Cookie does not exist
        console.log('No cookie found.');
    }

    function getCookie(name) {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();
            if (cookie.startsWith(name + '=')) {
                return cookie.substring(name.length + 1);
            }
        }
        return '';
    }
</script>
@endsection