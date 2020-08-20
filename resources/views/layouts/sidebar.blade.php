<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" style="font-size: 15px;">เมนู</li>
                @if (!Auth::user()->isFinance() )
                <li>
                    <a style="font-size: 15px;" href="/shipping" class="waves-effect">
                        <i class="bx bx-home"></i>
                        <span><b>รายการย้ายคลัง</b></span>
                        {{-- Home --}}
                    </a>
                </li>
                @endif
                @if (!Auth::user()->isShipping() )
                <li>
                    <a style="font-size: 15px;" href="/finance" class="waves-effect">
                        <i class="bx bx-home"></i>
                        <span><b>การเงิน</b></span>
                        {{-- Home --}}
                    </a>
                </li>
                @endif
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->