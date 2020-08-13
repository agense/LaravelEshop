<form action="{{route('pages.contact.send')}}" method="post" class="contact-form">
    {{ csrf_field() }}   
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
       <label for="name">Name</label>
       <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
       @if ($errors->has('name'))
       <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
       @endif
    </div>
    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}" >
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{old('email')}}" class="form-control">
        @if ($errors->has('email'))
        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
     </div>
    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="name">Title</label>
        <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control">
        @if ($errors->has('title'))
        <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
        <label for="content">Message</label>
        <textarea name="content" id="content" class="form-control">{{old('content')}}</textarea>
        @if ($errors->has('content'))
        <span class="help-block"><strong>{{ $errors->first('content') }}</strong></span>
        @endif
    </div>
    <div>
    <button type="send" class="button btn-black btn-full-narrow mt-4">Send</a>
    </div>
    </form>