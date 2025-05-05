<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{!! route('dashboard') !!}" class="header-logo">
            <img src="{!! asset('logo.png') !!}" style="height: 5rem;" alt="logo"
                 class="desktop-logo">
            <img src="{!! asset('logo.png') !!}" style="height: 5rem;" alt="logo" class="toggle-logo">
            <img src="{!! asset('logo.png') !!}" style="height: 5rem;" alt="logo"
                 class="desktop-white">
            <img src="{!! asset('logo.png') !!}" style="height: 5rem;" alt="logo"
                 class="toggle-white">

        </a>
    </div>
    <!-- End::main-sidebar-header -->
    <div class="d-none" id="Sales-bar"></div>
    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{!! route('dashboard') !!}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/>
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/>
                        </svg>
                        <span class="side-menu__label">Dashboard</span>

                    </a>
                </li>
                <li class="slide has-sub {{  request()->is('admin/goods-receipt*')||     request()->is('admin/permissions*') || request()->is('admin/users*') || request()->is('admin/suppliers*') || request()->is('admin/vendor*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"></path>
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"></path>
                        </svg>
                        <span class="side-menu__label">User Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">

                        {{-- Roles --}}
                        <li class="slide has-sub {{ request()->is('admin/roles*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Roles
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{!! route('admin.roles.index') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">List</a>
                                </li>
                                <li class="slide">
                                    <a href="{!! route('admin.roles.create') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.roles.create') ? 'active' : '' }}">Create
                                        New</a>
                                </li>
                            </ul>
                        </li>

                        {{-- Permissions --}}
                        <li class="slide has-sub {{ request()->is('admin/permissions*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Permissions
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{!! route('admin.permissions.index') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.permissions.index') ? 'active' : '' }}">List</a>
                                </li>
                                <li class="slide">
                                    <a href="{!! route('admin.permissions.create') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.permissions.create') ? 'active' : '' }}">Create
                                        New</a>
                                </li>
                            </ul>
                        </li>

                        {{-- Users --}}
                        <li class="slide has-sub {{ request()->routeIs('admin.users.index') && !request()->has('role') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Users
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{!! route('admin.users.index') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.users.index') && !request()->has('role') ? 'active' : '' }}">
                                        List
                                    </a>
                                </li>
                                <li class="slide">
                                    <a href="{!! route('admin.users.create') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                                        Create New
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- QA Users --}}
                        <li class="slide has-sub {{ request()->routeIs('admin.users.index') && request()->input('role') === 'QA' ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">QA Users
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{!! route('admin.users.index', ['role' => 'QA']) !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.users.index') && request()->input('role') === 'QA' ? 'active' : '' }}">
                                        List
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Operator Users --}}
                        <li class="slide has-sub {{ request()->routeIs('admin.users.index') && request()->input('role') === 'Operator' ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Operator Users
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{!! route('admin.users.index', ['role' => 'Operator']) !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.users.index') && request()->input('role') === 'Operator' ? 'active' : '' }}">
                                        List
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Suppliers --}}
                        <li class="slide has-sub {{ request()->is('admin/suppliers*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Suppliers
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{!! route('admin.suppliers.index') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.suppliers.index') ? 'active' : '' }}">List</a>
                                </li>
                                <li class="slide">
                                    <a href="{!! route('admin.suppliers.create') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.suppliers.create') ? 'active' : '' }}">Create
                                        New</a>
                                </li>
                            </ul>
                        </li>

                        {{-- Vendor --}}
                        <li class="slide has-sub {{ request()->is('admin/vendor*') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Vendor
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide">
                                    <a href="{!! route('admin.vendor.index') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.vendor.index') ? 'active' : '' }}">List</a>
                                </li>
                                <li class="slide">
                                    <a href="{!! route('admin.vendor.create') !!}"
                                       class="side-menu__item {{ request()->routeIs('admin.vendor.create') ? 'active' : '' }}">Create
                                        New</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="slide has-sub  {{ request()->is('admin/packing*') ||request()->is('admin/inventory*') || request()->is('admin/batches*') || request()->is('admin/purchaseorders*') || request()->is('admin/goods-issuance*') || request()->is('admin/formulations*')  || request()->is('admin/products*') || request()->is('admin/roles*') || request()->is('admin/grns*') || request()->is('admin/units*') || request()->is('admin/processes*') ||request()->is('admin/raw-material*')  ? 'active open' : '' }} ">

                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"></path>
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"></path>
                        </svg>
                        <span class="side-menu__label">Supply Chain</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>


                    <ul class="slide-menu child1">
                        <li class="slide has-sub {{ request()->is('admin/purchaseorders*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Purchase Orders
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.purchaseorders.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.purchaseorders.index') !!}"
                                       class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.purchaseorders.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.purchaseorders.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/grns*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">GRN
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.grns.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.grns.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.grns.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.grns.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/units*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Units
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.units.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.units.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.units.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.units.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/processes*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Processes
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.processes.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.processes.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.processes.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.processes.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/raw-material*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Raw
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.raw-material.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.raw-material.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.raw-material.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.raw-material.create') !!}"
                                       class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/products*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Products
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.products.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.products.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/products*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Categories
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.categories.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.categories.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/products*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Packing Materials
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.packing-materials.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.packing-materials.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.packing-materials.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.packing-materials.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/formulations*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Formulation
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.formulations.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.formulations.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.formulations.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.formulations.create') !!}"
                                       class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/batches*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Batches
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.batches.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.batches.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.batches.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.batches.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/goods-issuance*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Goods-Issuance
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.goods-issuance.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.goods-issuance.index') !!}"
                                       class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.goods-issuance.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.goods-issuance.create') !!}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/goods-receipt*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Goods-Receipt
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.goods-receipt.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.goods-receipt.index') !!}"
                                       class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.goods-receipt.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.goods-receipt.create') !!}"
                                       class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/packing*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Packing
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.packing.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.packing.index') !!}" class="side-menu__item">List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.packing.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.packing.create') !!}" class="side-menu__item">Create</a>
                                </li>

                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/inventory*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Inventory
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.inventory.index') !!}" class="side-menu__item">List</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub  {{ request()->is('admin/inventory*') || request()->is('admin/goods-issuance*') || request()->is('admin/formulations*')  || request()->is('admin/products*') || request()->is('admin/roles*') || request()->is('admin/grns*') || request()->is('admin/units*') || request()->is('admin/processes*') ||request()->is('admin/raw-material*')  ? 'active open' : '' }} ">

                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"></path>
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"></path>
                        </svg>
                        <span class="side-menu__label">Sale</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>


                    <ul class="slide-menu child1">
                        <li class="slide has-sub {{ request()->is('admin/pos*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">POS
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.pos.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.pos.create') !!}" class="side-menu__item">Create</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.pos.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.pos.index') !!}"
                                       class="side-menu__item">List</a>
                                </li>

                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/customers*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Customers
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.customers.create') ? 'active' : '' }}">
                                    <a href="{!! route('admin.customers.create') !!}" class="side-menu__item">Create</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
                                    <a href="{!! route('admin.customers.index') !!}"
                                       class="side-menu__item">List</a>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </li>

                <li class="slide has-sub {{ request()->is('admin/companies*') || request()->is('admin/branches*') || request()->is('admin/country*') || request()->is('admin/city*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path
                                d="M5 9h14V5H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5S7.83 8.5 7 8.5 5.5 7.83 5.5 7 6.17 5.5 7 5.5zM5 19h14v-4H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5z"
                                opacity=".3"/>
                            <path
                                d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zm-1 6H5v-4h14v4zm-12-.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 6H5V5h14v4zM7 8.5c.83 0 1.5-.67 1.5-1.5S7.83 5.5 7 5.5 5.5 6.17 5.5 7 6.17 8.5 7 8.5z"/>
                        </svg>
                        <span class="side-menu__label">Basic Settings</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">

                        <li class="slide has-sub {{ request()->is('admin/companies*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Companies
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.companies.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.companies.index') }}" class="side-menu__item"> List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.companies.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.companies.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>

                        <li class="slide has-sub {{ request()->is('admin/branches*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Branches
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.branches.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.branches.index') }}" class="side-menu__item"> List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.branches.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.branches.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>

                        <li class="slide has-sub {{ request()->is('admin/country*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Country
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.country.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.country.index') }}" class="side-menu__item"> List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.country.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.country.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>

                        <li class="slide has-sub {{ request()->is('admin/city*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">City
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.city.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.city.index') }}" class="side-menu__item"> List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.city.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.city.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

                <li class="slide has-sub  ">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path
                                d="M5 9h14V5H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5S7.83 8.5 7 8.5 5.5 7.83 5.5 7 6.17 5.5 7 5.5zM5 19h14v-4H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z"
                                opacity=".3"/>
                            <path
                                d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zm-1 6H5v-4h14v4zm-12-.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 6H5V5h14v4zM7 8.5c.83 0 1.5-.67 1.5-1.5S7.83 5.5 7 5.5 5.5 6.17 5.5 7 6.17 8.5 7 8.5z"/>
                        </svg>
                        <span class="side-menu__label">Accounts</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">

                        <li class="slide has-sub   ">
                            <a href="javascript:void(0);" class="side-menu__item"> Groups
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide active">
                                    <a href="{!! route('admin.account_groups.index') !!}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.account_groups.create') !!}" class="side-menu__item">
                                        create</a>
                                </li>

                            </ul>
                        </li>
                        <li class="slide has-sub   ">
                            <a href="javascript:void(0);" class="side-menu__item">Ledgers
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide active">
                                    <a href="{!! route('admin.ledger.index') !!}" class="side-menu__item"> List</a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.ledger.create') !!}" class="side-menu__item">
                                        create</a>
                                </li>

                            </ul>
                        </li>
                        <li class="slide has-sub   ">
                            <a href="javascript:void(0);" class="side-menu__item">Voucher
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide active">
                                    <a href="{!! route('admin.gjv-create') !!}" class="side-menu__item"> GJV Create</a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.crv-create') !!}" class="side-menu__item">
                                        CJV Create</a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.brv-create') !!}" class="side-menu__item"> BRV Create</a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.cpv-create') !!}" class="side-menu__item"> CPV Create</a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.bpv-create') !!}" class="side-menu__item"> BPV Create</a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.entries.index') !!}" class="side-menu__item"> All
                                        Entries</a>
                                </li>

                            </ul>
                        </li>
                        <li class="slide has-sub   ">
                            <a href="javascript:void(0);" class="side-menu__item"> Reports
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide active">
                                    <a href="{!! route('admin.chart-of-accounts.index') !!}" class="side-menu__item">
                                        chart Of account </a>
                                </li>
                                <li class="slide active">
                                    <a href="{!! route('admin.account_groups.create') !!}" class="side-menu__item">
                                        create</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub {{ request()->is('admin/holidays*') || request()->is('admin/hrm-leave-types*')  ||  request()->is('admin/staff*')  ||request()->is('admin/leave-entitlement*')  ||  request()->is('admin/hrm-leave-requests*') ||  request()->is('admin/hrm-leaves*') || request()->is('admin/loan-plans*')  || request()->is('admin/loans*')  || request()->is('admin/work-shifts*')  || request()->is('admin/work-weeks*') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path
                                d="M5 9h14V5H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5S7.83 8.5 7 8.5 5.5 7.83 5.5 7 6.17 5.5 7 5.5zM5 19h14v-4H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5z"
                                opacity=".3"/>
                            <path
                                d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zm-1 6H5v-4h14v4zm-12-.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 6H5V5h14v4zM7 8.5c.83 0 1.5-.67 1.5-1.5S7.83 5.5 7 5.5 5.5 6.17 5.5 7 6.17 8.5 7 8.5z"/>
                        </svg>
                        <span class="side-menu__label">HR</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide has-sub {{ request()->is('admin/staff*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Staff
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.staff.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.staff.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.staff.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.staff.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/holidays*')  ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Holidays
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.holidays.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.holidays.index') }}" class="side-menu__item"> List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.holidays.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.holidays.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/hrm-leave-types*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">leave Types
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.hrm-leave-types.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leave-types.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.hrm-leave-types.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leave-types.create') }}"
                                       class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>

                        <li class="slide has-sub {{ request()->is('admin/leave-entitlement*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Leave Entitlement
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.leave-entitlement.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.leave-entitlement.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.leave-entitlement.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.leave-entitlement.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/hrm-leave-requests*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item"> leave Requests
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.hrm-leave-requests.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leave-requests.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.hrm-leave-requests.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leave-requests.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/hrm-leaves*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item"> Leaves
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.hrm-leaves.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leave-requests.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.hrm-leaves.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leaves.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/hrm-leave-statuses*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">leave statuses
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.hrm-leave-statuses.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leave-statuses.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.hrm-leave-statuses.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hrm-leave-statuses.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>

                        <li class="slide has-sub {{ request()->is('admin/loan-plans*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Loan Plans
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.loan-plans.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.loan-plans.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.loan-plans.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.loan-plans.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/loans*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Loans
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.loans.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.loans.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.loans.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.loans.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/work-shifts*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Work Shifts
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.work-shifts.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.work-shifts.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.work-shifts.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.work-shifts.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>
                        <li class="slide has-sub {{ request()->is('admin/work-weeks*') ? 'open' : '' }}">
                            <a href="javascript:void(0);" class="side-menu__item">Work Weeks
                                <i class="fe fe-chevron-right side-menu__angle"></i></a>
                            <ul class="slide-menu child2">
                                <li class="slide {{ request()->routeIs('admin.work-weeks.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.work-weeks.index') }}" class="side-menu__item">
                                        List</a>
                                </li>
                                <li class="slide {{ request()->routeIs('admin.work-weeks.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.work-weeks.create') }}" class="side-menu__item">Create</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
    </div>
    <!-- End::main-sidebar -->

</aside>
