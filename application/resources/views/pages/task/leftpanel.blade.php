<!--title-->
@include('pages.task.components.title')



<!--[dependency][lock-1] start-->
@if(config('visibility.task_is_locked'))
<div class="alert alert-warning">@lang('lang.task_dependency_info_cannot_be_started')</div>
@else

<!--module extension point - allows modules to inject content-->
@stack('section_task_left_panel_one')


<!--description-->
@include('pages.task.components.description')

<!--module extension point - allows modules to inject content-->
@stack('section_task_left_panel_two')

<!--checklist-->
<div id="checklist-wrapper">
    @include('pages.task.components.checklists')

    <!--module extension point - allows modules to inject content-->
    @stack('section_task_left_panel_checklist')
</div>


<!--module extension point - allows modules to inject content-->
@stack('section_task_left_panel_three')


<!--attachments-->
@include('pages.task.components.attachments')

<!--module extension point - allows modules to inject content-->
@stack('section_task_left_panel_four')


<!--comments-->
@if(config('visibility.tasks_standard_features'))
<div class="card-comments" id="card-comments">
    <div class="x-heading"><i class="mdi mdi-message-text"></i>Comments</div>
    <div class="x-content">
        @include('pages.task.components.post-comment')
        <!--comments-->
        <div id="card-comments-container">
            <!--dynamic content here-->
        </div>

        <!--module extension point - allows modules to inject content-->
        @stack('section_task_left_panel_comments')

    </div>
</div>
@endif
@endif
<!--[dependency][lock-1] end-->

<!--module extension point - allows modules to inject content-->
@stack('section_task_left_panel_five')