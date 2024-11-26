<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta charset="utf-8" content="{{url('/admin')}}" id="base-url">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/customer/images/favicon.ico')}}" />

    @include('admin.layouts.head')
</head>

<body class="container-fluid">
    <!-- DEMO CONTENT - THEME SETTINGS -->
    <!-- This portion of code can be deleted -->
    <div id="theme-options-settings" class="theme-options">
        <div class="theme-options-panel layout-align-start-start layout-row">
            <div class="theme-options-panel-toggle"><i class="material-icons">settings</i></div>
            <div class="theme-options-list">
                <div class="theme-option">
                    <div class="option-title">Layout Options:</div>
                    <div class="radio-group">
                        <label>
                                <input id="themeOpt1" class="switch switch-primary" type="checkbox" />
                                <span>Dark Header Brand</span>
                            </label>
                        <label>
                                <input id="themeOpt2" class="switch switch-primary" type="checkbox" />
                                <span>Dark Header Toolbar</span>
                            </label>
                        <label>
                                <input id="themeOpt3" class="switch switch-primary" type="checkbox" />
                                <span>Dark Sidebar</span>
                            </label>
                        <label>
                                <input id="themeOpt4" class="switch switch-primary" type="checkbox" />
                                <span>Collapsed Sidebar <small><abbr title="Experimental State">(Exp.)</abbr></small></span>
                            </label>
                        <label>
                                <input id="themeOpt5" class="switch switch-primary" type="checkbox" checked />
                                <span>Alternative Page Header</span>
                            </label>

                        <label>
                                <input id="themeOpt6" class="switch switch-primary" type="checkbox" />
                                <span>Fixed Footer</span>
                            </label>
                        <label>
                                <input id="themeOpt7" class="switch switch-success" type="checkbox" />
                                <span>Boxed Layout</span>
                            </label>
                    </div>
                </div>
                <!-- /.theme-option -->
                <div class="divider-horizontal"></div>
                <div class="theme-option">
                    <div class="option-title">Global Config:</div>
                    <div class="radio-group">
                        <label>
                                <input id="themeOpt8" class="switch switch-info" type="checkbox" />
                                <span>Material Page Transition</span>
                            </label>
                        <label>
                                <input id="themeOpt9" class="switch switch-info" type="checkbox" />
                                <span>Sidebar Menu Accordion</span>
                            </label>
                    </div>
                </div>
                <!-- /.theme-option -->
            </div>
            <!-- /.theme-options-list -->
        </div>
        <!-- /.theme-options-panel -->
    </div>
    <div id="theme-options-style" class="theme-options">
        <div class="theme-options-panel layout-align-start-start layout-row">
            <div class="theme-options-panel-toggle"><i class="material-icons">palette</i></div>
            <div class="theme-options-list">
                <div class="theme-option">
                    <div class="option-title">Color Skin:</div>
                    <div class="radio-group">
                        <label>
                                <input id="themeStyle1" class="switch themeStyle switch-primary activeTheme" type="radio" name="themeRadio" data-theme="theme-default" checked />
                                <span>Default Theme</span>
                            </label>
                        <label>
                                <input id="themeStyle2" class="switch themeStyle switch-primary" type="radio" name="themeRadio" data-theme="theme-1-forgedsteel"/>
                                <span>ForgedSteel Theme</span>
                            </label>
                        <label>
                                <input id="themeStyle3" class="switch themeStyle switch-primary" type="radio" name="themeRadio" data-theme="theme-2-bubblegum"/>
                                <span>Bubblegum Theme</span>
                            </label>
                        <label>
                                <input id="themeStyle4" class="switch themeStyle switch-primary" type="radio" name="themeRadio" data-theme="theme-3-flat"/>
                                <span>Flat Theme</span>
                            </label>
                    </div>
                </div>
                <!-- /.theme-option -->

                <div class="divider-horizontal"></div>
                <div class="theme-option">
                    <div class="option-title">Color Skin Primary Color:</div>
                    <div class="colorSwitcher flex-display">
                        <div class="margin-right-1 margin-bottom-1 bordered cursor-pointer border-circle colorTheme primary-style" title="Theme Primary Color Style" data-toggle="tooltip" data-theme="primary"></div>
                        <div class="margin-right-1 margin-bottom-1 bordered cursor-pointer border-circle colorTheme success-style" title="Theme Success Color Style" data-toggle="tooltip" data-theme="success"></div>
                        <div class="margin-right-1 margin-bottom-1 bordered cursor-pointer border-circle colorTheme info-style" title="Theme Info Color Style" data-toggle="tooltip" data-theme="info"></div>
                        <div class="margin-right-1 margin-bottom-1 bordered cursor-pointer border-circle colorTheme warning-style" title="Theme Warning Color Style" data-toggle="tooltip" data-theme="warning"></div>
                        <div class="margin-right-1 margin-bottom-1 bordered cursor-pointer border-circle colorTheme danger-style" title="Theme Danger Color Style" data-toggle="tooltip" data-theme="danger"></div>
                    </div>
                </div>
                <!-- /.theme-option -->

                <div class="divider-horizontal"></div>
                <div class="theme-option">
                    <div class="option-title">Userbox Background:</div>
                    <div class="radio-group">
                        <label>
                                <input id="themeStyle5" class="switch switch-info" type="checkbox" />
                                <span>Colored Background</span>
                            </label>
                    </div>
                </div>
                <!-- /.theme-option -->

                <div class="divider-horizontal"></div>
                <div class="theme-option">
                    <div class="option-title">Boxed Layout Background:</div>
                    <div id="patternSwitcher" class="pattern-bg padding-bottom-1 has-custom-scrollbar">
                        <div class="pattern-bg-inner">
                            <img src="{{asset('assets/admin/img/binding_dark-xs.png')}}" data-pattern="binding_dark.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/brickwall-xs.png')}}" data-pattern="brickwall.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/congruent_outline-xs.png')}}" data-pattern="congruent_outline.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/congruent_pentagon-xs.png')}}" data-pattern="congruent_pentagon.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/dark_embroidery-xs.png')}}" data-pattern="dark_embroidery.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/footer_lodyas-xs.png')}}" data-pattern="footer_lodyas.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/graphy-xs.png')}}" data-pattern="graphy.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/halftone-xs.png')}}" data-pattern="halftone.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/notebook-xs.png')}}" data-pattern="notebook.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/pw_pattern-xs.png')}}" data-pattern="pw_pattern.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/seamless_paper_texture-xs.png')}}" data-pattern="seamless_paper_texture.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/sos-xs.png')}}" data-pattern="sos.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/squared_metal-xs.png')}}" data-pattern="squared_metal.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/stardust-xs.png')}}" data-pattern="stardust.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/transp_bg-xs.png')}}" data-pattern="transp_bg.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/tree_bark-xs.png')}}" data-pattern="tree_bark.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/triangular-xs.png')}}" data-pattern="triangular.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/tweed-xs.png')}}" data-pattern="tweed.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/wood_texture-xs.png')}}" data-pattern="wood_texture.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                            <img src="{{asset('assets/admin/img/zwartevilt-xs.png')}}" data-pattern="zwartevilt.png" width="22" height="22" class="margin-right-1 margin-bottom-1 bordered cursor-pointer" />
                        </div>
                    </div>
                </div>
                <!-- /.theme-option -->
            </div>
            <!-- /.theme-options-list -->
        </div>
        <!-- /.theme-options-panel -->
    </div>
    <!-- This portion of code can be deleted -->
    <!-- END DEMO CONTENT - THEME SETTINGS -->
    <!--<div id="sidebar-backdrop"></div>-->
    <div id="page-wrapper">
        @include('admin.layouts.sidebar')
        <section id="right-content">

            @include('admin.layouts.navbar')
            
            @yield('content')
        </section>
        <!-- /#right-content -->
    </div>
    @include('admin.layouts.script')
    
</body>