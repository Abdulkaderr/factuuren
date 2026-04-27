<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" id="js-trigger-nav-team">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav" id="main-sidenav">
            <ul id="sidebarnav">


                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_1')

                <!--home-->
                <li class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.home')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/home" aria-expanded="false" target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.dashboard')) }}
                        </span>
                    </a>
                </li>

                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_2')

                <!--customer-->
                @if(config('visibility.menu_customers'))
                <li class="sidenav-menu-item {{ $page['mainmenu_customers'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.customers')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/customers" aria-expanded="false" target="_self">
                        <i class="sl-icon-people">
                            @if(!config('app.application_demo_mode') &&
                            config('system.count_tenant_email_config_status') > 0 &&
                            config('customer_defaults.defaults_email_delivery') == 'smtp_and_sendmail')
                            <span class="notify email-blinking-icon-table" id="menu_tenant_email_config_status"> <span
                                    class="heartbit"></span> <span class="point"></span> </span>
                            @endif
                        </i>
                        <span class="hide-menu">{{ cleanLang(__('lang.customers')) }}
                        </span>
                    </a>
                </li>
                @endif

                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_3')

                <!--packages-->
                @if(config('visibility.menu_packages'))
                <li class="sidenav-menu-item {{ $page['mainmenu_packages'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.packages')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/packages" aria-expanded="false" target="_self">
                        <i class="sl-icon-diamond"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.packages')) }}
                        </span>
                    </a>
                </li>
                @endif


                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_4')

                <!--subscriptions-->
                @if(config('visibility.menu_subscriptions'))
                <li class="sidenav-menu-item {{ $page['mainmenu_subscriptions'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.subscriptions')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/subscriptions" aria-expanded="false"
                        target="_self">
                        <i class="ti-reload"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.subscriptions')) }}
                        </span>
                    </a>
                </li>
                @endif


                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_5')

                <!--payments-->
                @if(config('visibility.menu_payments'))
                <li data-modular-id="main_menu_team_clients"
                    class="sidenav-menu-item {{ $page['mainmenu_payments'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="ti-credit-card"></i>
                        <span class="hide-menu">@lang('lang.payments')
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="sidenav-submenu {{ $page['submenu_online'] ?? '' }}" id="submenu_online">
                            <a href="/app-admin/payments"
                                class="{{ $page['submenu_online'] ?? '' }}">@lang('lang.online')</a>
                        </li>
                        <li class="sidenav-submenu {{ $page['submenu_offline'] ?? '' }}" id="submenu_offline">
                            <a href="/app-admin/offline-payments"
                                class="{{ $page['submenu_offline'] ?? '' }}">@lang('lang.offline')</a>
                        </li>
                    </ul>
                </li>
                @endif


                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_6')

                <!--blogs-->
                <li class="sidenav-menu-item hidden {{ $page['mainmenu_blogs'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.blogs')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/blogs" aria-expanded="false" target="_self">
                        <i class="sl-icon-docs"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.blogs')) }}
                        </span>
                    </a>
                </li>


                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_7')

                <!--events-->
                @if(config('visibility.menu_events'))
                <li class="sidenav-menu-item {{ $page['mainmenu_events'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.events')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/events" aria-expanded="false" target="_self">
                        <i class="ti-time"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.events')) }}
                        </span>
                    </a>
                </li>
                @endif

                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_8')

                <!--team-->
                @if(config('visibility.menu_team'))
                <li class="sidenav-menu-item {{ $page['mainmenu_team'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="@lang('lang.team')">
                    <a class="waves-effect waves-dark" href="/app-admin/team" aria-expanded="false" target="_self">
                        <i class="sl-icon-user-follow"></i>
                        <span class="hide-menu">@lang('lang.team')
                        </span>
                    </a>
                </li>
                @endif

                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_9')

                <!--frontend-->
                @if(config('visibility.menu_settings'))
                <li class="sidenav-menu-item {{ $page['mainmenu_frontend'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.frontend')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/frontend/start" aria-expanded="false"
                        target="_self">
                        <i class="sl-icon-picture"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.frontend')) }}
                        </span>
                    </a>
                </li>
                @endif

                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_10')

                <!--settings-->
                @if(config('visibility.menu_settings'))
                <li class="sidenav-menu-item {{ $page['mainmenu_settings'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.settings')) }}">
                    <a class="waves-effect waves-dark" href="/app-admin/settings/general" aria-expanded="false"
                        target="_self">
                        <i class="sl-icon-settings"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.settings')) }}
                        </span>
                    </a>
                </li>
                @endif

                <!--module extension point - allows modules to inject content-->
                @stack('landlord_main_menu_11')

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>