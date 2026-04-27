<div class="header-cover" id="hero-header-cover" {!! clean(getDocumentHeroImage($document->doc_hero_direcory ?? '',
    $document->doc_hero_filename ?? '', $document->doc_hero_updated ?? '', $document->doc_type)) !!}>
    <!--draft-->
    <div class="document-status-ribbon bg-draft {{ documentRibbonVisibility('draft', $document->doc_status) }}"
        id="doc_status_ribbon_draft">
        @lang('lang.draft')
    </div>
    <!--new-->
    <div class="document-status-ribbon bg-info {{ documentRibbonVisibility('new', $document->doc_status) }}"
        id="doc_status_ribbon_new">
        @lang('lang.new')
    </div>
    <!--accepted-->
    <div class="document-status-ribbon bg-success {{ documentRibbonVisibility('accepted', $document->doc_status) }}"
        id="doc_status_ribbon_accepted">
        @lang('lang.accepted')
    </div>
    <!--declined-->
    <div class="document-status-ribbon bg-danger {{ documentRibbonVisibility('declined', $document->doc_status) }}"
        id="doc_status_ribbon_declined">
        @lang('lang.declined')
    </div>
    <!--revised-->
    <div class="document-status-ribbon bg-primary {{ documentRibbonVisibility('revised', $document->doc_status) }}"
        id="doc_status_ribbon_revised">
        @lang('lang.revised')
    </div>
    <!--expired-->
    <div class="document-status-ribbon bg-danger {{ documentRibbonVisibility('expired', $document->doc_status) }}"
        id="doc_status_ribbon_expired">
        @lang('lang.expired')
    </div>
    <!--awiting-signature-->
    <div class="document-status-ribbon bg-warning {{ documentRibbonVisibility('awaiting_signatures', $document->doc_status) }}"
        id="doc_status_ribbon_awaiting_signatures">
        @lang('lang.awaiting_signatures')
    </div>
    <!--active-->
    <div class="document-status-ribbon bg-info {{ documentRibbonVisibility('active', $document->doc_status) }}"
        id="doc_status_ribbon_active">
        @lang('lang.active')
    </div>

    <div class="doc-hero-header {{ documentEditingModeCheck1($payload['mode'] ?? '') }}"
        data-block-styling="hero-heading" id="doc-element-hero">
        <!--editing icons-->
        <div class="doc-edit-icon {{ documentEditingModeCheck2($payload['mode'] ?? '') }}">
            <span class="x-edit-icon js-toggle-side-panel" data-reset-form='skip'
                data-target="documents-side-panel-hero" data-value-header="{{ $document->doc_heading }}"
                data-value-title="{{ $document->doc_title }}">
                <i class="sl-icon-note"></i>
            </span>
        </div>

        <!--main heading-->
        <div class="main-heading" data-block-src="block_sub_heading_1" {!! clean(getFontColor($document->
            doc_heading_color ?? '')) !!}>{{ $document->doc_heading }}</div>

        <!--document title-->
        <div class="main-title" {!! clean(getFontColor($document->doc_title_color ?? '')) !!}>{{ $document->doc_title }}


            <!--proposals automation icon-->
            @if($document->doc_type == 'proposal')
            <span>
                @if(auth()->check() && auth()->user()->is_team )
                @if(auth()->check() && auth()->user()->role->role_proposals >= 2)
                <!--show editing icon (automation)-->
                <a href="javascript:void(0)" id="proposal-automation-icon"
                    class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form {{ runtimeVisibility('proposal-automation-icon', $document->proposal_automation_status) }}"
                    data-toggle="modal" data-target="#commonModal"
                    data-url="{{ urlResource('/proposals/'.$document->doc_id.'/edit-automation') }}"
                    data-loading-target="commonModalBody" data-modal-title="@lang('lang.proposal_automation')"
                    data-action-url="{{ urlResource('/proposals/'.$document->doc_id.'/edit-automation') }}"
                    data-action-method="POST" data-action-ajax-loading-target="commonModalBody">
                    <i class="sl-icon-energy text-warning cursor-pointer" data-toggle="tooltip"
                        title="{{ cleanLang(__('lang.proposal_automation')) }}"></i>
                </a>
                @else
                <!--show plain icon (automation)-->
                <i class="sl-icon-energy text-warning cursor-pointer {{ runtimeVisibility('proposal-automation-icon', $document->proposal_automation_status) }}"
                    data-toggle="tooltip" id="proposal-automation-icon"
                    title="{{ cleanLang(__('lang.proposal_automation')) }}"></i>
                @endif
                @endif
            </span>
            @endif

            <!--contracts automation icon-->
            @if($document->doc_type == 'contract')
            <span>
                @if(auth()->check() && auth()->user()->is_team )
                @if(auth()->check() && auth()->user()->role->role_contracts >= 2)
                <!--show editing icon (automation)-->
                <a href="javascript:void(0)" id="contract-automation-icon"
                    class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form {{ runtimeVisibility('contract-automation-icon', $document->contract_automation_status) }}"
                    data-toggle="modal" data-target="#commonModal"
                    data-url="{{ urlResource('/contracts/'.$document->doc_id.'/edit-automation') }}"
                    data-loading-target="commonModalBody" data-modal-title="@lang('lang.contract_automation')"
                    data-action-url="{{ urlResource('/contracts/'.$document->doc_id.'/update-automation') }}"
                    data-action-method="PUT" data-action-ajax-loading-target="commonModalBody">
                    <i class="sl-icon-energy text-warning cursor-pointer" data-toggle="tooltip"
                        title="{{ cleanLang(__('lang.contract_automation')) }}"></i>
                </a>
                @else
                <!--show plain icon (automation)-->
                <i class="sl-icon-energy text-warning cursor-pointer {{ runtimeVisibility('contract-automation-icon', $document->contract_automation_status) }}"
                    data-toggle="tooltip" id="contract-automation-icon"
                    title="{{ cleanLang(__('lang.contract_automation')) }}"></i>
                @endif
                @endif
            </span>
            @endif
        </div>
    </div>
</div>