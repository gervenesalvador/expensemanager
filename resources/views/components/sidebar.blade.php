<nav id="sidebar">

    <div class="sidebar-header">
        <img src="/images/default-profile.jpg" alt="Profile Picture">
        <p>{{ Auth::user()->name }}</p>
    </div>

    <ul class="list-unstyled components">
        
        <?php $segment = Request::segment(1); ?>
        <li class="{{ $segment == '' ? 'active' : '' }}">
            <a href="/home">Dashboard</a>
        </li>

        @if (Auth::user()->role_id == 1)

            <li class="{{ $segment == 'users' || $segment == 'roles' ? 'active' : '' }}">
                <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">User Management</a>
                <ul class="collapse list-unstyled" id="userSubmenu">
                    <li>
                        <a href="/roles">Roles</a>
                    </li>
                    <li>
                        <a href="/users">User</a>
                    </li>
                </ul>
            </li>

            <li class="{{ $segment == 'expenses' || $segment == 'expense-category' ? 'active' : '' }}">
                <a href="#expenseSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Expense Management</a>
                <ul class="collapse list-unstyled" id="expenseSubmenu">
                    <li>
                        <a href="/expense-category">Expense Categories</a>
                    </li>
                    <li>
                        <a href="/expenses">Expense</a>
                    </li>
                </ul>
            </li>

        @else

            <li class="{{ $segment == 'expenses' ? 'active' : '' }}">
                <a href="/expenses">Expense</a>
            </li>

        @endif
    </ul>
    
</nav>