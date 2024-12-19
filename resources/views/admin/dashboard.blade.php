<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="{{ route('admin.librarians') }}">Manage Librarians</a> |
            <a href="{{ route('admin.requests') }}">Handle Requests</a> |
            <a href="{{ route('logout') }}">Logout</a>
        </nav>
    </header>

    <main>
        <section id="manage-librarians">
            <h2>Manage Librarians</h2>
            <form action="{{ route('admin.addLibrarian') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Librarian Name" required>
                <input type="email" name="email" placeholder="Librarian Email" required>
                <button type="submit">Add Librarian</button>
            </form>

            <h3>Current Librarians</h3>
            <ul>
                @foreach ($librarians as $librarian)
                    <li>
                        {{ $librarian->name }} ({{ $librarian->email }})
                        <form action="{{ route('admin.deleteLibrarian', $librarian->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </section>

        <section id="handle-requests">
            <h2>Handle Requests</h2>
            <h3>Requests from Librarians</h3>
            <ul>
                @foreach ($librarianRequests as $request)
                    <li>
                        Request: {{ $request->description }}
                        <form action="{{ route('admin.approveRequest', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <h3>Requests from Students</h3>
            <ul>
                @foreach ($studentRequests as $request)
                    <li>
                        Request: {{ $request->description }}
                        <form action="{{ route('admin.approveStudentRequest', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </section>
    </main>
</body>
</html>
