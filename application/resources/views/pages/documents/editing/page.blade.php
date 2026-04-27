@extends('pages.documents.wrapper')
@section('document')
<div class="col-12">

    <div class="docs-main-wrapper editing-mode box-shadow">

        <!--hero header-->
        <div class="hero-header-wrapper" id="hero-header-wrapper">
            <!--[element] here header-->
            @include('pages.documents.elements.hero')
        </div>


            <!--[element] doc to and by-->
            @include('pages.documents.elements.doc-to-by')

            <!--[element] dates-->
            @include('pages.documents.elements.doc-details')

        <div class="doc-body">
            <!--[element] editor-->
            @include('pages.documents.elements.doc-editor')
        </div>
    </div>
</div>
<!--filter panels-->
@if(auth()->user()->is_team)
@include('pages.documents.editing.sidepanel-hero')
@include('pages.documents.editing.sidepanel-billing')
@include('pages.documents.editing.sidepanel-details')

@if($document->doc_type == 'contract')
@include('pages.documents.editing.contract.sidepanel-variables')
@endif
@if($document->doc_type == 'proposal')
@include('pages.documents.editing.proposal.sidepanel-variables')

@endif
@endif
<!--filter-->
@endsection