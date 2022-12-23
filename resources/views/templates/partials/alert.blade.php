@if(session()->has('info'))
    <div class="alert alert-info">
        <span>{{session()->get('info')}}</span>
    </div>
@endif