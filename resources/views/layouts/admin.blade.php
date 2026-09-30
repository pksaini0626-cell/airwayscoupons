<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }} | AirwaysCoupons Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
        :root {
            --admin-primary: #0284c7;
            --admin-dark: #0f172a;
            --admin-sidebar: #1e293b;
            --admin-bg: #f1f5f9;
            --admin-card: #ffffff;
            --admin-border: #e2e8f0;
            --admin-text: #334155;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, sans-serif; background-color: var(--admin-bg); color: var(--admin-text); display: flex; min-height: 100vh; }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }
        a { text-decoration: none; color: inherit; }

        /* SIDEBAR */
        .admin-sidebar {
            width: 260px;
            background: var(--admin-sidebar);
            color: #94a3b8;
            padding: 24px 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 0 24px 24px;
            border-bottom: 1px solid #334155;
            color: white;
            font-size: 1.3rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            color: #cbd5e1;
            transition: all 0.2s ease;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--admin-primary);
            color: white;
        }

        /* MAIN CONTENT */
        .admin-main {
            margin-left: 260px;
            flex: 1;
            padding: 30px 40px;
            min-height: 100vh;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            background: white;
            padding: 20px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            border: 1px solid var(--admin-border);
        }

        .admin-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--admin-dark);
        }

        .btn-admin {
            background: var(--admin-primary);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s ease;
        }

        .btn-admin:hover {
            background: #0369a1;
        }

        .btn-danger {
            background: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        /* CARDS & TABLES */
        .admin-card {
            background: white;
            border-radius: 16px;
            padding: 26px;
            border: 1px solid var(--admin-border);
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            margin-bottom: 24px;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .admin-table th {
            background: #f8fafc;
            text-align: left;
            padding: 14px 18px;
            font-weight: 700;
            color: #64748b;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table td {
            padding: 16px 18px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .admin-table tr:hover {
            background: #f8fafc;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-gray { background: #f1f5f9; color: #64748b; }
        .badge-warning { background: #fef3c7; color: #92400e; }

        /* FORM INPUTS */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: var(--admin-dark);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--admin-border);
            border-radius: 10px;
            font-size: 0.95rem;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--admin-primary);
        }

        /* MODAL */
        .admin-modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-modal {
            background: white;
            border-radius: 18px;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body>
    @auth
        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div>
                <div class="sidebar-brand">
                    <span>✈️</span> Airways Admin
                </div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ url('/admin') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/coupons') }}" class="{{ request()->is('admin/coupons*') ? 'active' : '' }}">
                            🏷️ Manage Coupons
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/airlines') }}" class="{{ request()->is('admin/airlines*') ? 'active' : '' }}">
                            ✈️ Manage Airlines
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/settings') }}" class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                            ⚙️ Site Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}" target="_blank">
                            🌐 View Live Site
                        </a>
                    </li>
                </ul>
            </div>
            <div style="padding: 0 24px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.95rem;">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="admin-main">
            <header class="admin-header">
                <div>
                    <h1 class="admin-title">{{ $title ?? 'Admin Dashboard' }}</h1>
                    <p style="font-size: 0.88rem; color: #64748b;">Welcome back, {{ Auth::user()->name }}</p>
                </div>
                <div>
                    <a href="{{ url('/') }}" target="_blank" class="btn-admin" style="background: #0f172a;">
                        🌐 Live Site
                    </a>
                </div>
            </header>

            {{ $slot }}
        </main>
    @else
        <!-- LOGIN ONLY WRAPPER -->
        <main style="flex: 1; display: flex; align-items: center; justify-content: center; min-height: 100vh;">
            {{ $slot }}
        </main>
    @endauth

    @livewireScripts
</body>
</html>
