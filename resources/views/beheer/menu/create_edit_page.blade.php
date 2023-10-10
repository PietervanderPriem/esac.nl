<div class="card mt-4">
    <div class="card-header"><h3>{{$fields['title_page']}}</h3></div>
    <div class="card-body">
        <div class="form-group">
            {{Form::label('content',  trans('menuItems.content_en'))}}
            {{Form::textarea('content',($page != null) ?  $page->content : "",array('class' => 'form-control', 'id' => 'content_en'))}}
        </div>
    </div>
</div>
