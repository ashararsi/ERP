<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="light" data-toggled="close">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    @yield('meta')

    @include('admin.layout.css')

    <style>
        .fas.fa-edit {
            margin-left: 10px;
            margin-right: 10px;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>
    @yield('css')
</head>
<body>

<!-- Start Switcher -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="border-bottom border-block-end-dashed">
            <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-home"
                        type="button" role="tab" aria-controls="switcher-home" aria-selected="true">Theme Styles
                </button>
                <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-profile"
                        type="button" role="tab" aria-controls="switcher-profile" aria-selected="false">Theme Colors
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel"
                 aria-labelledby="switcher-home-tab"
                 tabindex="0">
                <div class="">
                    <p class="switcher-style-head">Theme Color Mode:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-light-theme">
                                    Light
                                </label>
                                <input class="form-check-input" type="radio" name="theme-style"
                                       id="switcher-light-theme"
                                       checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-dark-theme">
                                    Dark
                                </label>
                                <input class="form-check-input" type="radio" name="theme-style"
                                       id="switcher-dark-theme">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Directions:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-ltr">
                                    LTR
                                </label>
                                <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-rtl">
                                    RTL
                                </label>
                                <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Navigation Styles:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-vertical">
                                    Vertical
                                </label>
                                <input class="form-check-input" type="radio" name="navigation-style"
                                       id="switcher-vertical"
                                       checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-horizontal">
                                    Horizontal
                                </label>
                                <input class="form-check-input" type="radio" name="navigation-style"
                                       id="switcher-horizontal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navigation-menu-styles">
                    <p class="switcher-style-head">Vertical & Horizontal Menu Styles:</p>
                    <div class="row switcher-style gx-0 pb-2 gy-2">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-menu-click">
                                    Menu Click
                                </label>
                                <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                       id="switcher-menu-click">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-menu-hover">
                                    Menu Hover
                                </label>
                                <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                       id="switcher-menu-hover">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-icon-click">
                                    Icon Click
                                </label>
                                <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                       id="switcher-icon-click">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-icon-hover">
                                    Icon Hover
                                </label>
                                <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                       id="switcher-icon-hover">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidemenu-layout-styles">
                    <p class="switcher-style-head">Sidemenu Layout Styles:</p>
                    <div class="row switcher-style gx-0 pb-2 gy-2">
                        <div class="col-sm-6">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-default-menu">
                                    Default Menu
                                </label>
                                <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                       id="switcher-default-menu" checked>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-closed-menu">
                                    Closed Menu
                                </label>
                                <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                       id="switcher-closed-menu">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-icontext-menu">
                                    Icon Text
                                </label>
                                <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                       id="switcher-icontext-menu">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-icon-overlay">
                                    Icon Overlay
                                </label>
                                <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                       id="switcher-icon-overlay">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-detached">
                                    Detached
                                </label>
                                <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                       id="switcher-detached">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-double-menu">
                                    Double Menu
                                </label>
                                <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                       id="switcher-double-menu">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Page Styles:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-regular">
                                    Regular
                                </label>
                                <input class="form-check-input" type="radio" name="page-styles" id="switcher-regular"
                                       checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-classic">
                                    Classic
                                </label>
                                <input class="form-check-input" type="radio" name="page-styles" id="switcher-classic">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-modern">
                                    Modern
                                </label>
                                <input class="form-check-input" type="radio" name="page-styles" id="switcher-modern">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Layout Width Styles:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-full-width">
                                    Full Width
                                </label>
                                <input class="form-check-input" type="radio" name="layout-width"
                                       id="switcher-full-width"
                                       checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-boxed">
                                    Boxed
                                </label>
                                <input class="form-check-input" type="radio" name="layout-width" id="switcher-boxed">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Menu Positions:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-menu-fixed">
                                    Fixed
                                </label>
                                <input class="form-check-input" type="radio" name="menu-positions"
                                       id="switcher-menu-fixed"
                                       checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-menu-scroll">
                                    Scrollable
                                </label>
                                <input class="form-check-input" type="radio" name="menu-positions"
                                       id="switcher-menu-scroll">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Header Positions:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-header-fixed">
                                    Fixed
                                </label>
                                <input class="form-check-input" type="radio" name="header-positions"
                                       id="switcher-header-fixed" checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-header-scroll">
                                    Scrollable
                                </label>
                                <input class="form-check-input" type="radio" name="header-positions"
                                       id="switcher-header-scroll">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Loader:</p>
                    <div class="row switcher-style gx-0">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-loader-enable">
                                    Enable
                                </label>
                                <input class="form-check-input" type="radio" name="page-loader"
                                       id="switcher-loader-enable" checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-loader-disable">
                                    Disable
                                </label>
                                <input class="form-check-input" type="radio" name="page-loader"
                                       id="switcher-loader-disable" checked>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel"
                 aria-labelledby="switcher-profile-tab" tabindex="0">
                <div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Menu Colors:</p>
                        <div class="d-flex switcher-style pb-2">
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Light Menu" type="radio" name="menu-colors"
                                       id="switcher-menu-light" checked>
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Dark Menu" type="radio" name="menu-colors"
                                       id="switcher-menu-dark">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Color Menu" type="radio" name="menu-colors"
                                       id="switcher-menu-primary">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Gradient Menu" type="radio" name="menu-colors"
                                       id="switcher-menu-gradient">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-transparent"
                                       data-bs-toggle="tooltip" data-bs-placement="top" title="Transparent Menu"
                                       type="radio" name="menu-colors" id="switcher-menu-transparent">
                            </div>
                        </div>
                        <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically change
                            from below Theme Primary color picker
                        </div>
                    </div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Header Colors:</p>
                        <div class="d-flex switcher-style pb-2">
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Light Header" type="radio" name="header-colors"
                                       id="switcher-header-light" checked>
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Dark Header" type="radio" name="header-colors"
                                       id="switcher-header-dark">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Color Header" type="radio" name="header-colors"
                                       id="switcher-header-primary">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Gradient Header" type="radio" name="header-colors"
                                       id="switcher-header-gradient">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Transparent Header" type="radio"
                                       name="header-colors"
                                       id="switcher-header-transparent">
                            </div>
                        </div>
                        <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically
                            change from below Theme Primary color picker
                        </div>
                    </div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Theme Primary:</p>
                        <div class="d-flex flex-wrap align-items-center switcher-style">
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-primary-1" type="radio"
                                       name="theme-primary" id="switcher-primary">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-primary-2" type="radio"
                                       name="theme-primary" id="switcher-primary1">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-primary-3" type="radio"
                                       name="theme-primary"
                                       id="switcher-primary2">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-primary-4" type="radio"
                                       name="theme-primary"
                                       id="switcher-primary3">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-primary-5" type="radio"
                                       name="theme-primary"
                                       id="switcher-primary4">
                            </div>
                            <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                <div class="theme-container-primary"></div>
                                <div class="pickr-container-primary"></div>
                            </div>
                        </div>
                    </div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Theme Background:</p>
                        <div class="d-flex flex-wrap align-items-center switcher-style">
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-bg-1" type="radio"
                                       name="theme-background" id="switcher-background">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-bg-2" type="radio"
                                       name="theme-background" id="switcher-background1">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-bg-3" type="radio"
                                       name="theme-background"
                                       id="switcher-background2">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-bg-4" type="radio"
                                       name="theme-background" id="switcher-background3">
                            </div>
                            <div class="form-check switch-select me-3">
                                <input class="form-check-input color-input color-bg-5" type="radio"
                                       name="theme-background" id="switcher-background4">
                            </div>
                            <div class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                <div class="theme-container-background"></div>
                                <div class="pickr-container-background"></div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-image mb-3">
                        <p class="switcher-style-head">Menu With Background Image:</p>
                        <div class="d-flex flex-wrap align-items-center switcher-style">
                            <div class="form-check switch-select m-2">
                                <input class="form-check-input bgimage-input bg-img1" type="radio"
                                       name="theme-background" id="switcher-bg-img">
                            </div>
                            <div class="form-check switch-select m-2">
                                <input class="form-check-input bgimage-input bg-img2" type="radio"
                                       name="theme-background" id="switcher-bg-img1">
                            </div>
                            <div class="form-check switch-select m-2">
                                <input class="form-check-input bgimage-input bg-img3" type="radio"
                                       name="theme-background"
                                       id="switcher-bg-img2">
                            </div>
                            <div class="form-check switch-select m-2">
                                <input class="form-check-input bgimage-input bg-img4" type="radio"
                                       name="theme-background" id="switcher-bg-img3">
                            </div>
                            <div class="form-check switch-select m-2">
                                <input class="form-check-input bgimage-input bg-img5" type="radio"
                                       name="theme-background" id="switcher-bg-img4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between canvas-footer gap-1">
                <a href="javascript:void(0);" id="reset-all" class="btn btn-danger flex-fill">Reset</a>
            </div>
        </div>
    </div>
</div>
<!-- End Switcher -->
<!-- Loader -->
<div id="loader">
    <img src="{!! asset('admin/assets/images/media/loader.svg') !!}" alt="">
</div>
<!-- Loader -->

<div class="page">
    <!-- app-header -->
    <header class="app-header">

        <!-- Start::main-header-container -->
        <div class="main-header-container container-fluid">

            <!-- Start::header-content-left -->
            <div class="header-content-left">

                <!-- Start::header-element -->
                <div class="header-element">
                    <div class="horizontal-logo">
                        <a href="{!! route('dashboard')  !!}" class="header-logo">
                            <img src="{!! asset('admin/assets/images/brand-logos/desktop-logo.png') !!}" alt="logo"
                                 class="desktop-logo">
                            <img src="{!! asset('admin/assets/images/brand-logos/toggle-logo.png') !!}" alt="logo"
                                 class="toggle-logo">
                            <img src="{!! asset('admin/assets/images/brand-logos/desktop-white.png') !!}" alt="logo"
                                 class="desktop-white">
                            <img src="{!! asset('admin/assets/images/brand-logos/toggle-white.png') !!}" alt="logo"
                                 class="toggle-white">
                        </a>
                    </div>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link -->
                    <a aria-label="Hide Sidebar"
                       class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                       data-bs-toggle="sidebar" href="javascript:void(0);">
                        <i class="header-icon fe fe-align-left"></i>
                    </a>
                    <div class="main-header-center d-none d-lg-block">
                        <input class="form-control" placeholder="Search for anything..." type="search">
                        <button class="btn"><i class="fa fa-search d-none d-md-block"></i></button>
                    </div>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-left -->

            <!-- Start::header-content-right -->
            <div class="header-content-right">

                <div class="header-element Search-element d-block d-lg-none">
                    <!-- Start::header-link|dropdown-toggle -->
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside"
                       data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="header-link-icon">
                            <path
                                d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/>
                        </svg>
                    </a>
                    <!-- End::header-link|dropdown-toggle -->
                    <ul class="main-header-dropdown dropdown-menu dropdown-menu-end Search-element-dropdown"
                        data-popper-placement="none">
                        <li>
                            <div class="input-group w-100 p-2">
                                <input type="text" class="form-control" placeholder="Search....">
                                <div class="btn btn-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Start::header-element -->
                <div class="header-element country-selector">
                    <!-- Start::header-link|dropdown-toggle -->
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside"
                       data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="flag-icon1">
                            <circle cx="256" cy="256" r="256" fill="#f0f0f0"></circle>
                            <g fill="#0052b4">
                                <path
                                    d="M52.92 100.142c-20.109 26.163-35.272 56.318-44.101 89.077h133.178L52.92 100.142zM503.181 189.219c-8.829-32.758-23.993-62.913-44.101-89.076l-89.075 89.076h133.176zM8.819 322.784c8.83 32.758 23.993 62.913 44.101 89.075l89.074-89.075H8.819zM411.858 52.921c-26.163-20.109-56.317-35.272-89.076-44.102v133.177l89.076-89.075zM100.142 459.079c26.163 20.109 56.318 35.272 89.076 44.102V370.005l-89.076 89.074zM189.217 8.819c-32.758 8.83-62.913 23.993-89.075 44.101l89.075 89.075V8.819zM322.783 503.181c32.758-8.83 62.913-23.993 89.075-44.101l-89.075-89.075v133.176zM370.005 322.784l89.075 89.076c20.108-26.162 35.272-56.318 44.101-89.076H370.005z"></path>
                            </g>
                            <g fill="#d80027">
                                <path
                                    d="M509.833 222.609H289.392V2.167A258.556 258.556 0 00256 0c-11.319 0-22.461.744-33.391 2.167v220.441H2.167A258.556 258.556 0 000 256c0 11.319.744 22.461 2.167 33.391h220.441v220.442a258.35 258.35 0 0066.783 0V289.392h220.442A258.533 258.533 0 00512 256c0-11.317-.744-22.461-2.167-33.391z"></path>
                                <path
                                    d="M322.783 322.784L437.019 437.02a256.636 256.636 0 0015.048-16.435l-97.802-97.802h-31.482v.001zM189.217 322.784h-.002L74.98 437.019a256.636 256.636 0 0016.435 15.048l97.802-97.804v-31.479zM189.217 189.219v-.002L74.981 74.98a256.636 256.636 0 00-15.048 16.435l97.803 97.803h31.481zM322.783 189.219L437.02 74.981a256.328 256.328 0 00-16.435-15.047l-97.802 97.803v31.482z"></path>
                            </g>
                        </svg>
                    </a>
                    <!-- End::header-link|dropdown-toggle -->
                    <ul class="main-header-dropdown dropdown-menu dropdown-menu-end country-dropdown"
                        data-popper-placement="none">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span>
                                        <img src="../assets/images/flags/french_flag.jpg" alt="img"
                                             class="avatar avatar-xs lh-1 me-2">
                                    </span>
                                French
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span>
                                        <img src="../assets/images/flags/germany_flag.jpg" alt="img"
                                             class="avatar avatar-xs lh-1 me-2">
                                    </span>
                                German
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span>
                                        <img src="../assets/images/flags/italy_flag.jpg" alt="img"
                                             class="avatar avatar-xs lh-1 me-2">
                                    </span>
                                Italian
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span>
                                        <img src="../assets/images/flags/russia_flag.jpg" alt="img"
                                             class="avatar avatar-xs lh-1 me-2">
                                    </span>
                                Russian
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                    <span>
                                        <img src="../assets/images/flags/spain_flag.jpg" alt="img"
                                             class="avatar avatar-xs lh-1 me-2">
                                    </span>
                                Spanish
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element header-theme-mode">
                    <!-- Start::header-link|layout-setting -->
                    <a href="javascript:void(0);" class="header-link layout-setting">
                            <span class="light-layout">
                                <!-- Start::header-link-icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24"
                                     viewBox="0 -960 960 960" width="24"><path
                                        d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z"/></svg>
                                <!-- End::header-link-icon -->
                            </span>
                        <span class="dark-layout">
                                <!-- Start::header-link-icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" fill="currentColor"
                                     height="24" viewBox="0 -960 960 960" width="24"><path
                                        d="M480-360q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0 80q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Zm326-268Z"/></svg>
                            <!-- End::header-link-icon -->
                            </span>
                    </a>
                    <!-- End::header-link|layout-setting -->
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element messages-dropdown">
                    <!-- Start::header-link|dropdown-toggle -->
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside"
                       data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24px"
                             viewBox="0 0 24 24" width="24px" fill="currentColor">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path
                                d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"/>
                        </svg>
                        <span class="pulse-danger"></span>
                    </a>
                    <!-- End::header-link|dropdown-toggle -->
                    <!-- Start::main-header-dropdown -->
                    <div class="main-header-dropdown dropdown-menu dropdown-menu-end main-header-message"
                         data-popper-placement="none">
                        <div class="menu-header-content bg-primary text-fixed-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 fs-15 fw-semibold text-fixed-white">Messages</h6>
                                <span class="badge rounded-pill bg-warning pt-1 text-fixed-black">Mark All Read</span>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-fixed-white op-6 pb-0 fs-12 ">You have 4
                                unread messages</p>
                        </div>
                        <div>
                            <hr class="dropdown-divider">
                        </div>
                        <ul class="list-unstyled mb-0" id="header-cart-items-scroll">
                            <li class="dropdown-item">
                                <div class="d-flex messages">
                                        <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                                            <img src="../assets/images/faces/12.jpg" alt="img">
                                        </span>
                                    <div>
                                        <div class="d-flex">
                                            <a href="chat.html"><h6 class="mb-1 name">Petey Cruiser</h6></a>
                                        </div>
                                        <p class="mb-0 fs-12 desc">I'm sorry but i'm not sure how to help you with
                                            that......</p>
                                        <p class="time mb-0 text-start float-start ms-2 mt-2">Mar 15 3:55 PM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="d-flex messages">
                                        <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                                            <img src="../assets/images/faces/3.jpg" alt="img">
                                        </span>
                                    <div>
                                        <div class="d-flex">
                                            <a href="chat.html"><h6 class="mb-1 name">Jimmy Changa</h6></a>
                                        </div>
                                        <p class="mb-0 fs-12 desc">All set ! Now, time to get to you now......</p>
                                        <p class="time mb-0 text-start float-start ms-2 mt-2">Mar 06 01:12 AM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="d-flex messages">
                                        <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                                            <img src="../assets/images/faces/5.jpg" alt="img">
                                        </span>
                                    <div>
                                        <div class="d-flex">
                                            <a href="chat.html"><h6 class="mb-1 name">Graham Cracker</h6></a>
                                        </div>
                                        <p class="mb-0 fs-12 desc">Are you ready to pickup your Delivery...</p>
                                        <p class="time mb-0 text-start float-start ms-2 mt-2">Feb 25 10:35 AM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="d-flex messages">
                                        <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                                            <img src="../assets/images/faces/4.jpg" alt="img">
                                        </span>
                                    <div>
                                        <div class="d-flex">
                                            <a href="chat.html"><h6 class="mb-1 name">Donatella Nobatti</h6></a>
                                        </div>
                                        <p class="mb-0 fs-12 desc">Here are some products ...</p>
                                        <p class="time mb-0 text-start float-start ms-2 mt-2">Feb 12 05:12 PM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="d-flex messages">
                                        <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                                            <img src="../assets/images/faces/1.jpg" alt="img">
                                        </span>
                                    <div>
                                        <div class="d-flex">
                                            <a href="chat.html"><h6 class="mb-1 name">Anne Fibbiyon</h6></a>
                                        </div>
                                        <p class="mb-0 fs-12 desc">I'm sorry but i'm not sure how...</p>
                                        <p class="time mb-0 text-start float-start ms-2 mt-2">Jan 29 03:16 PM</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center dropdown-footer">
                            <a href="chat.html" class="text-primary fs-13">VIEW ALL</a>
                        </div>
                    </div>
                    <!-- End::main-header-dropdown -->
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element notifications-dropdown main-header-notification">
                    <!-- Start::header-link|dropdown-toggle -->
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"
                       data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" height="24px"
                             viewBox="0 0 24 24" width="24px" fill="currentColor">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path
                                d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                        </svg>
                        <span class="pulse-success"></span>
                    </a>
                    <!-- End::header-link|dropdown-toggle -->
                    <!-- Start::main-header-dropdown -->
                    <div class="main-header-dropdown dropdown-menu dropdown-menu-end main-header-message"
                         data-popper-placement="none">
                        <div class="menu-header-content bg-primary text-fixed-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 fs-15 fw-semibold text-fixed-white">Notifications</h6>
                                <span class="badge rounded-pill bg-warning pt-1 text-fixed-black">Mark All Read</span>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-fixed-white op-6 pb-0 fs-12 ">You have 4
                                unread Notifications</p>
                        </div>
                        <div>
                            <hr class="dropdown-divider">
                        </div>
                        <ul class="list-unstyled mb-0" id="header-notification-scroll">
                            <li class="dropdown-item px-3">
                                <div class="d-flex">
                                        <span class="avatar avatar-md me-2 avatar-rounded flex-shrink-0 bg-pink">
                                            <i class="la la-file-alt fs-20"></i>
                                        </span>
                                    <div class="ms-3">
                                        <a href="mail.html"><h5 class="notification-label text-dark mb-1">New files
                                                available</h5></a>
                                        <div class="notification-subtext">10 hour ago</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item px-3">
                                <div class="d-flex">
                                        <span class="avatar avatar-md me-2 avatar-rounded flex-shrink-0 bg-purple">
                                            <i class="la la-gem fs-20"></i>
                                        </span>
                                    <div class="ms-3">
                                        <a href="mail.html"><h5 class="notification-label text-dark mb-1">Updates
                                                Available</h5></a>
                                        <div class="notification-subtext">2 days ago</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item px-3">
                                <div class="d-flex">
                                        <span class="avatar avatar-md me-2 avatar-rounded flex-shrink-0 bg-success">
                                            <i class="la la-shopping-basket fs-20"></i>
                                        </span>
                                    <div class="ms-3">
                                        <a href="mail.html"><h5 class="notification-label text-dark mb-1">New Order
                                                Received</h5></a>
                                        <div class="notification-subtext">1 hour ago</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item px-3">
                                <div class="d-flex">
                                        <span class="avatar avatar-md me-2 avatar-rounded flex-shrink-0 bg-warning">
                                            <i class="la la-envelope-open fs-20 text-fixed-white"></i>
                                        </span>
                                    <div class="ms-3">
                                        <a href="mail.html"><h5 class="notification-label text-dark mb-1">New review
                                                received</h5></a>
                                        <div class="notification-subtext">1 day ago</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item px-3">
                                <div class="d-flex">
                                        <span class="avatar avatar-md me-2 avatar-rounded flex-shrink-0 bg-danger">
                                            <i class="la la-user-check fs-20"></i>
                                        </span>
                                    <div class="ms-3">
                                        <a href="mail.html"><h5 class="notification-label text-dark mb-1">22 verified
                                                registrations</h5></a>
                                        <div class="notification-subtext">2 hour ago</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-item px-3">
                                <div class="d-flex">
                                        <span class="avatar avatar-md me-2 avatar-rounded flex-shrink-0 bg-primary">
                                            <i class="la la-check-circle fs-20"></i>
                                        </span>
                                    <div class="ms-3">
                                        <a href="mail.html"><h5 class="notification-label text-dark mb-1">Project has
                                                been approved</h5></a>
                                        <div class="notification-subtext">4 hour ago</div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="mail.html"><i class="las la-angle-right text-end text-muted icon"></i></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center dropdown-footer">
                            <a href="mail.html" class="text-primary fs-13">VIEW ALL</a>
                        </div>
                    </div>
                    <!-- End::main-header-dropdown -->
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element header-fullscreen">
                    <!-- Start::header-link -->
                    <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="full-screen-open full-screen-icon header-link-icon" height="24px"
                             viewBox="0 0 24 24" width="24px" fill="currentColor">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="full-screen-close full-screen-icon header-link-icon d-none" fill="currentColor"
                             height="24" viewBox="0 -960 960 960" width="24">
                            <path
                                d="M320-200v-120H200v-80h200v200h-80Zm240 0v-200h200v80H640v120h-80ZM200-560v-80h120v-120h80v200H200Zm360 0v-200h80v120h120v80H560Z"/>
                        </svg>
                    </a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element header-sidebar">
                    <!-- Start::header-link-->
                    <a href="javascript:void(0);" class="header-link" data-bs-toggle="offcanvas"
                       data-bs-target="#header-sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                    <!-- End::header-link-->
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element headerProfile-dropdown">
                    <!-- Start::header-link|dropdown-toggle -->
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                       data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="../assets/images/faces/6.jpg" alt="img" width="37" height="37" class="rounded-circle">
                    </a>
                    <!-- End::header-link|dropdown-toggle -->
                    <ul class="main-header-dropdown dropdown-menu pt-0 header-profile-dropdown dropdown-menu-end main-profile-menu"
                        aria-labelledby="mainHeaderProfile">
                        <li>
                            <div class="main-header-profile bg-primary menu-header-content text-fixed-white">
                                <div class="my-auto">
                                    <h6 class="mb-0 lh-1 text-fixed-white">{!! auth()->user()->name !!}</h6><span
                                        class="fs-11 op-7 lh-1">Premium Member</span>
                                </div>
                            </div>
                        </li>
                        <li><a class="dropdown-item d-flex" href=""><i
                                    class="bx bx-user-circle fs-18 me-2 op-7"></i>Profile</a></li>
                        <li><a class="dropdown-item d-flex" href=""><i
                                    class="bx bx-cog fs-18 me-2 op-7"></i>Edit Profile </a></li>
                        <li><a class="dropdown-item d-flex border-block-end" href="mail.html"><i
                                    class="bx bxs-inbox fs-18 me-2 op-7"></i>Inbox</a></li>
                        <li><a class="dropdown-item d-flex" href=""><i
                                    class="bx bx-envelope fs-18 me-2 op-7"></i>Messages</a></li>
                        <li><a class="dropdown-item d-flex border-block-end" href=""><i
                                    class="bx bx-slider-alt fs-18 me-2 op-7"></i>Account Settings</a></li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-log-out"></i> Sign Out
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </ul>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link|switcher-icon -->
                    <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas"
                       data-bs-target="#switcher-canvas">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="24" height="24"
                             viewBox="0 0 24 24">
                            <path
                                d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z"></path>
                            <path
                                d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z"></path>
                        </svg>
                    </a>
                    <!-- End::header-link|switcher-icon -->
                </div>
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-right -->

        </div>
        <!-- End::main-header-container -->

    </header>
    <!-- /app-header -->


    <!--End modal -->
    <!-- Start::app-sidebar -->
    @include('admin.layout.sidebar')
    <!-- End::app-sidebar -->

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- End::app-content -->
    {{--@include('admin.layout.notification')--}}

    <!-- Footer Start -->
    <footer class="footer mt-auto py-3 bg-white text-center">
        <div class="container">
                <span class="text-muted"> Copyright © <span id="year"></span>    Lasani Pharma, Design and Developed by BoostByte Technologies Pvt, Ltd.
                </span>
        </div>
    </footer>
    <!-- Footer End -->

</div>


<!-- Scroll To Top -->
<div class="scrollToTop">
    <span class="arrow"><i class="las la-angle-double-up"></i></span>
</div>
<div id="responsive-overlay"></div>
<!-- Scroll To Top -->

@include('admin.layout.js')
@yield('js')


<script>
    // Show Loader
    function showLoader() {
        const loaderOverlay = document.createElement('div');
        loaderOverlay.className = 'loading-overlay';
        const loader = document.createElement('div');
        loader.className = 'loader';
        loaderOverlay.appendChild(loader);
        document.body.appendChild(loaderOverlay);
    }

    // Hide Loader
    function hideLoader() {
        const loaderOverlay = document.querySelector('.loading-overlay');
        if (loaderOverlay) {
            document.body.removeChild(loaderOverlay);
        }
    }

</script>
</body>

</html>
