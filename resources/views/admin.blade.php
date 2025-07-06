<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    @vite(['resources/css/admin.css'])
</head>
<body>
    <div class="nav-bar">
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>

    </div>
    <h1>Admin Dashboard</h1>
    <div class="summary">
        <div class="summary-stat">
            <div class="stat-label">Total Bookings</div>
            <div class="stat-value">{{ $totalBookings }}</div>
        </div>
        <div class="summary-stat">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>

    <div class="filters">
        <form method="GET" action="/admin">
            <label for="ticketTypeFilter">Filter by Ticket Type:</label>
            <select id="ticketTypeFilter" name="type" onchange="this.form.submit()">
                <option value="all">All</option>
                <option value="general" {{ $ticketType == 'general' ? 'selected' : '' }}>General</option>
                <option value="student" {{ $ticketType == 'student' ? 'selected' : '' }}>Student</option>
                <option value="vip" {{ $ticketType == 'vip' ? 'selected' : '' }}>VIP</option>
                <option value="group" {{ $ticketType == 'group' ? 'selected' : '' }}>Group</option>
            </select>
        </form>
        <a href="/admin/export{{ $ticketType ? '?type=' . $ticketType : '' }}" class="download-csv">Download CSV</a>
    </div>

    <table style="margin-top:20px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Ticket</th>
                <th>Price</th>
                <th>Country</th>
                <th>Promo</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $b)
                <tr>
                    <td>{{ $b->name }}</td>
                    <td>{{ $b->email }}</td>
                    <td>{{ $b->phone }}</td>
                    <td>{{ $b->ticket_type }}</td>
                    <td>${{ $b->final_price }}</td>
                    <td>{{ $b->country }}</td>
                    <td>{{ $b->promo_code ?? 'N/A' }}</td>
                    <td>{{ $b->created_at }}</td>
                </tr>
            @empty
                <tr><td colspan="8">No bookings found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>