<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" id="js-trigger-nav-team">
    <!--[fix] keep id as "js-trigger-nav-team"-->
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul data-modular-id="main_menu_client" id="sidebarnav">

                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent1') !!}
                @stack('menu_main_client_1')

                <!--home-->
                <li data-modular-id="main_menu_client_home"
                    class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.home')) }}">
                    <a class="waves-effect waves-dark" href="/home" aria-expanded="false" target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.dashboard')) }}
                        </span>
                    </a>
                </li>
                <!--home-->

                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent2') !!}
                @stack('menu_main_client_2')

                <!--projects[home]-->
                @if(config('visibility.modules.projects'))
                <li data-modular-id="main_menu_client_projects"
                    class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.projects')) }}">
                    <a class="waves-effect waves-dark" href="{{ _url('/projects') }}" aria-expanded="false"
                        target="_self">
                        <i class="ti-folder"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.projects')) }}
                        </span>
                    </a>
                </li>
                @endif
                <!--projects-->


                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent3') !!}
                @stack('menu_main_client_3')

                @if(auth()->user()->is_client_owner)
                <li data-modular-id="main_menu_client_billing"
                    class="sidenav-menu-item {{ $page['mainmenu_client_billing'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="ti-wallet"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.billing')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @if(config('visibility.modules.invoices'))
                        <li class="sidenav-submenu {{ $page['submenu_invoices'] ?? '' }}" id="submenu_invoices">
                            <a href="/invoices"
                                class=" {{ $page['submenu_invoices'] ?? '' }}">{{ cleanLang(__('lang.invoices')) }}</a>
                        </li>
                        @endif
                        @if(config('visibility.modules.payments'))
                        <li class="sidenav-submenu {{ $page['submenu_payments'] ?? '' }}" id="submenu_payments">
                            <a href="/payments"
                                class=" {{ $page['submenu_payments'] ?? '' }}">{{ cleanLang(__('lang.payments')) }}</a>
                        </li>
                        @endif
                        <!--refunds-->
                        @if(config('visibility.modules.payments'))
                        <li class="sidenav-submenu {{ $page['submenu_refunds'] ?? '' }}" id="submenu_refunds">
                            <a href="/refunds"
                                class=" {{ $page['submenu_refunds'] ?? '' }}">@lang('lang.refunds')</a>
                        </li>
                        @endif
                        <!--refunds-->
                        @if(config('visibility.modules.estimates'))
                        <li class="sidenav-submenu {{ $page['submenu_estimates'] ?? '' }}" id="submenu_estimates">
                            <a href="/estimates"
                                class=" {{ $page['submenu_estimates'] ?? '' }}">{{ cleanLang(__('lang.estimates')) }}</a>
                        </li>
                        @endif
                        @if(config('visibility.modules.subscriptions'))
                        <li class="sidenav-submenu {{ $page['submenu_subscriptions'] ?? '' }}"
                            id="submenu_subscriptions">
                            <a href="/subscriptions"
                                class=" {{ $page['submenu_subscriptions'] ?? '' }}">{{ cleanLang(__('lang.subscriptions')) }}</a>
                        </li>
                        @endif
                        <!--[MODULES] - dynamic menu-->
                        {!! config('modules.menus.client.billing') !!}
                        @stack('menu_main_client_4')
                    </ul>
                </li>
                @endif

                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent4') !!}
                @stack('menu_main_client_5')

                <!--proposals-->
                @if(config('visibility.modules.proposals') && auth()->user()->is_client_owner)
                <li data-modular-id="main_menu_client_proposals"
                    class="sidenav-menu-proposals {{ $page['mainmenu_client_proposals'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.proposals')) }}">
                    <a class="waves-effect waves-dark p-r-20" href="/proposals" aria-expanded="false" target="_self">
                        <i class="ti-bookmark-alt"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.proposals')) }}
                        </span>
                    </a>
                </li>
                @endif


                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent5') !!}
                @stack('menu_main_client_6')

                <!--contracts-->
                @if(config('visibility.modules.contracts') && auth()->user()->is_client_owner)
                <li data-modular-id="main_menu_client_contracts"
                    class="sidenav-menu-item {{ $page['mainmenu_contracts'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.contracts')) }}">
                    <a class="waves-effect waves-dark p-r-20" href="/contracts" aria-expanded="false" target="_self">
                        <i class="ti-write"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.contracts')) }}
                        </span>
                    </a>
                </li>
                @endif



                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent5') !!}
                @stack('menu_main_client_7')

                <!--users-->
                @if(auth()->user()->is_client_owner)
                <li data-modular-id="main_menu_client_users"
                    class="sidenav-menu-item {{ $page['mainmenu_contacts'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.users')) }}">
                    <a class="waves-effect waves-dark" href="/users" aria-expanded="false" target="_self">
                        <i class="sl-icon-people"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.users')) }}
                        </span>
                    </a>
                </li>
                @endif
                <!--users-->


                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent7') !!}
                @stack('menu_main_client_8')

                <!--tickets-->
                @if(config('visibility.modules.tickets'))
                <li data-modular-id="main_menu_client_tickets"
                    class="sidenav-menu-item {{ $page['mainmenu_tickets'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.support_tickets')) }}">
                    <a class="waves-effect waves-dark" href="/tickets" aria-expanded="false" target="_self">
                        <i class="ti-comments"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.support')) }}
                        </span>
                    </a>
                </li>
                @endif
                <!--tickets-->


                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent8') !!}
                @stack('menu_main_client_9')

                <!--knowledgebase-->
                @if(config('visibility.modules.knowledgebase'))
                <li data-modular-id="main_menu_client_knowledgebase"
                    class="sidenav-menu-item {{ $page['mainmenu_kb'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.knowledgebase')) }}">
                    <a class="waves-effect waves-dark p-r-20" href="/knowledgebase" aria-expanded="false"
                        target="_self">
                        <i class="sl-icon-docs"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.knowledgebase')) }}
                        </span>
                    </a>
                </li>
                @endif
                <!--knowledgebase-->


                <!--[MODULES] - dynamic menu-->
                {!! config('modules.menus.main.parent9') !!}
                @stack('menu_main_client_10')

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>