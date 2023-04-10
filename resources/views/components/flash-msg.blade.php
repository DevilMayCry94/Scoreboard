@if(Session::has('error'))
    <div class="alert alert-danger">
        {{Session::get('error')}}
    </div>
@endif
@if(Session::has('warning'))
    <div class="alert alert-danger">
        {{Session::get('warning')}}
    </div>
@endif
@if(Session::has('info'))
    <div class="alert alert-danger">
        {{Session::get('info')}}
    </div>
@endif
@if(Session::has('success'))
    <script type="text/javascript">
        swal({
            title:'Success!',
            text:"{{Session::get('success')}}",
            timer:5000,
            type:'success'
        }).then((value) => {
            //location.reload();
        }).catch(swal.noop);
    </script>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
