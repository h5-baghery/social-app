<x-layout>
  
  <div class="container py-md-5 container--narrow">
    <form action="{{$edit ? route("createpost.update",['post' => $post]) : route("createpost.save")}}" method="POST">
      @csrf
      @if ($edit)
        @method('PUT')
        <p><small><strong><a href="{{route('singlepost', ['post' => $post->id])}}">&laquo; Back to permalink</a></strong></small></p>
      @endif
      <div class="form-group">
        <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
        <input name="title" id="post-title" value="{{old('title', $edit ? $post->title : '')}}" class="form-control form-control-lg form-control-title" type="text" autocomplete="off" />
        @error('title')
          <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
        @enderror
      </div>
      
      <div class="form-group">
        <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
        <textarea name="body" id="post-body" class="body-content tall-textarea form-control" type="text">{{old('body', $edit ? $post->body : '')}}</textarea>
      @error('body')
        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
      @enderror
      </div>

      <button class="btn btn-primary">{{$edit ? 'Update Post' : 'Save New Post'}}</button>
      @if ($edit)
      <a href="{{route('singlepost', ['post' => $post->id])}}" class="btn btn-secondary">Cancel</a>
      @else
      <a href="{{ url()->previous()}}" class="btn btn-secondary">Cancel</a>    
      @endif
    </form>
  </div>

</x-layout>