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
            {!! $document->doc_body !!}



            <!--signatures -->
            <div id="doc-signatures-container">
                @include('pages.documents.elements.signatures-contracts')
            </div>
        </div>
    </div>

</div>
@endsection