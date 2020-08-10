<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">เมนู</li>
                @if (Auth::user()->isShipping() || Auth::user()->isAdmin() )
                <li>
                    <a href="/shipping" class="waves-effect">
                        <i class="bx bx-home"></i>
                        <span>การส่งสินค้า</span>
                        {{-- Home --}}
                    </a>
                </li>
                @endif
                @if (Auth::user()->isFinance() || Auth::user()->isAdmin() )
                <li>
                    <a href="/finance" class="waves-effect">
                        <i class="bx bx-home"></i>
                        <span>การเงิน</span>
                        {{-- Home --}}
                    </a>
                </li>
                @endif
                @if (Auth::user()->isBilling() || Auth::user()->isAdmin() )
                <li>
                    <a href="/billing" class="waves-effect">
                        <i class="bx bx-home"></i>
                        <span>การเรียกเก็บเงิน</span>
                        {{-- Home --}}
                    </a>
                </li>
                @endif
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->